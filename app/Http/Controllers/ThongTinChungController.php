<?php

namespace App\Http\Controllers;

use App\Models\ThongTinChung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ThongTinChungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachThongTinChung = ThongTinChung::All();
        foreach ($danhSachThongTinChung as $tp) {
            $tp->thoi_diem_ra_mat = Carbon::createFromFormat('Y-m-d', $tp->thoi_diem_ra_mat)->format('d/m/Y');
        }
        return view('admin/management-page/generalinformation', ['danhSachThongTinChung' => $danhSachThongTinChung]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-generalinformation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreThongTinChungRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'thietke' => 'required|max:500',
                'chatlieu' => 'required|max:500',
                'kichthuockhoiluong' => 'required|max:500',
                'thoidiemramat' => 'required',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'thietke' => 'Thiết kế',
                'chatlieu' => 'Chất liệu',
                'kichthuockhoiluong' => 'Kích thước khối lượng',
                'thoidiemramat' => 'Thời điểm ra mắt',
            ]
        )->validate();

        $thongTinChung = new ThongTinChung();
        $thongTinChung->fill([
            'thiet_ke' => $request->input('thietke'),
            'chat_lieu' => $request->input('chatlieu'),
            'kich_thuoc_khoi_luong' => $request->input('kichthuockhoiluong'),
            'thoi_diem_ra_mat' => $request->input('thoidiemramat'),
        ]);
        if ($thongTinChung->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm thông tin chung thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm thông tin chung không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThongTinChung  $thongTinChung
     * @return \Illuminate\Http\Response
     */
    public function show(ThongTinChung $thongTinChung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThongTinChung  $thongTinChung
     * @return \Illuminate\Http\Response
     */
    public function edit(ThongTinChung $thongTinChung)
    {
        return view('admin/edit-page/edit-generalinformation', ['thongTinChung' => $thongTinChung]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateThongTinChungRequest  $request
     * @param  \App\Models\ThongTinChung  $thongTinChung
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThongTinChung $thongTinChung)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'thietke' => 'required|max:500',
                'chatlieu' => 'required|max:500',
                'kichthuockhoiluong' => 'required|max:500',
                'thoidiemramat' => 'required',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'thietke' => 'Thiết kế',
                'chatlieu' => 'Chất liệu',
                'kichthuockhoiluong' => 'Kích thước khối lượng',
                'thoidiemramat' => 'Thời điểm ra mắt',
            ]
        )->validate();

        $thongTinChung->fill([
            'thiet_ke' => $request->input('thietke'),
            'chat_lieu' => $request->input('chatlieu'),
            'kich_thuoc_khoi_luong' => $request->input('kichthuockhoiluong'),
            'thoi_diem_ra_mat' => $request->input('thoidiemramat'),
        ]);
        if ($thongTinChung->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật thông tin chung thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật thông tin chung không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThongTinChung  $thongTinChung
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThongTinChung $thongTinChung)
    {
        if ($thongTinChung->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa thông tin chung thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa thông tin chung không thành công !');
    }
}
