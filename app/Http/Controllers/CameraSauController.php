<?php

namespace App\Http\Controllers;

use App\Models\CameraSau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CameraSauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachCameraSau = CameraSau::All();
        return view('admin/management-page/backcamera', ['danhSachCameraSau' => $danhSachCameraSau]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-backcamera');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCameraSauRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'dophangiai' => 'required|max:500',
                'quayphim' => 'required|max:500',
                // 'denflash' => 'required|in:0,1',
                'denflash' => 'required|max:500',
                'tinhnang' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
                // 'in' => ':attribute không đúng kiểu dữ liệu cho phép !'
            ],
            [
                'dophangiai' => 'Độ phân giải',
                'quayphim' => 'Quay phim',
                'denflash' => 'Đèn flash',
                'tinhnang' => 'Tính năng',
            ]
        )->validate();

        $cameraSau = new CameraSau();
        $cameraSau->fill([
            'do_phan_giai' => $request->input('dophangiai'),
            'quay_phim' => $request->input('quayphim'),
            'den_flash' => $request->input('denflash'),
            'tinh_nang' => $request->input('tinhnang'),
        ]);
        if ($cameraSau->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm camera sau thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm camera sau không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CameraSau  $cameraSau
     * @return \Illuminate\Http\Response
     */
    public function show(CameraSau $cameraSau)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CameraSau  $cameraSau
     * @return \Illuminate\Http\Response
     */
    public function edit(CameraSau $cameraSau)
    {
        return view('admin/edit-page/edit-backcamera', ['cameraSau' => $cameraSau]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCameraSauRequest  $request
     * @param  \App\Models\CameraSau  $cameraSau
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CameraSau $cameraSau)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'dophangiai' => 'required|max:500',
                'quayphim' => 'required|max:500',
                // 'denflash' => 'required|in:0,1',
                'denflash' => 'required|max:500',
                'tinhnang' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
                // 'in' => ':attribute không đúng kiểu dữ liệu cho phép !'
            ],
            [
                'dophangiai' => 'Độ phân giải',
                'quayphim' => 'Quay phim',
                'denflash' => 'Đèn flash',
                'tinhnang' => 'Tính năng',
            ]
        )->validate();

        $cameraSau->fill([
            'do_phan_giai' => $request->input('dophangiai'),
            'quay_phim' => $request->input('quayphim'),
            'den_flash' => $request->input('denflash'),
            'tinh_nang' => $request->input('tinhnang'),
        ]);
        if ($cameraSau->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật camera sau thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật camera sau không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CameraSau  $cameraSau
     * @return \Illuminate\Http\Response
     */
    public function destroy(CameraSau $cameraSau)
    {
        if ($cameraSau->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa camera sau thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa camera sau không thành công !');
    }
}
