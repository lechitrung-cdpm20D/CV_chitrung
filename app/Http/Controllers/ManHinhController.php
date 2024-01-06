<?php

namespace App\Http\Controllers;

use App\Models\ManHinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManHinhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachManHinh = ManHinh::All();
        return view('admin/management-page/screen', ['danhSachManHinh' => $danhSachManHinh]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-screen');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreManHinhRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'congnghemanhinh' => 'required|max:500',
                'dophangiai' => 'required|max:500',
                'manhinhrong' => 'required|max:500',
                'dosangtoida' => 'required|max:500',
                'matkinhcamung' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'congnghemanhinh' => 'Công nghệ màn hình',
                'dophangiai' => 'Độ phân giải',
                'manhinhrong' => 'Màn hình rộng',
                'dosangtoida' => 'Độ sáng tối đa',
                'matkinhcamung' => 'Mặt kính cảm ứng',
            ]
        )->validate();

        $manHinh = new ManHinh();
            $manHinh->fill([
                'cong_nghe_man_hinh' => $request->input('congnghemanhinh'),
                'do_phan_giai' => $request->input('dophangiai'),
                'man_hinh_rong' => $request->input('manhinhrong'),
                'do_sang_toi_da' => $request->input('dosangtoida'),
                'mat_kinh_cam_ung' => $request->input('matkinhcamung'),
            ]);
            if ($manHinh->save() == true) {
                return redirect()->back()->with('thongbao', 'Thêm màn hình thành công !');
            }
            return redirect()->back()->with('thongbao', 'Thêm màn hình không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ManHinh  $manHinh
     * @return \Illuminate\Http\Response
     */
    public function show(ManHinh $manHinh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManHinh  $manHinh
     * @return \Illuminate\Http\Response
     */
    public function edit(ManHinh $manHinh)
    {
        return view('admin/edit-page/edit-screen', ['manHinh' => $manHinh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateManHinhRequest  $request
     * @param  \App\Models\ManHinh  $manHinh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManHinh $manHinh)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'congnghemanhinh' => 'required|max:500',
                'dophangiai' => 'required|max:500',
                'manhinhrong' => 'required|max:500',
                'dosangtoida' => 'required|max:500',
                'matkinhcamung' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'congnghemanhinh' => 'Công nghệ màn hình',
                'dophangiai' => 'Độ phân giải',
                'manhinhrong' => 'Màn hình rộng',
                'dosangtoida' => 'Độ sáng tối đa',
                'matkinhcamung' => 'Mặt kính cảm ứng',
            ]
        )->validate();

        $manHinh->fill([
            'cong_nghe_man_hinh' => $request->input('congnghemanhinh'),
            'do_phan_giai' => $request->input('dophangiai'),
            'man_hinh_rong' => $request->input('manhinhrong'),
            'do_sang_toi_da' => $request->input('dosangtoida'),
            'mat_kinh_cam_ung' => $request->input('matkinhcamung'),
        ]);
        if ($manHinh->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật màn hình thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật màn hình không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManHinh  $manHinh
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManHinh $manHinh)
    {
        if ($manHinh->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa màn hình thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa màn hình không thành công !');
    }
}
