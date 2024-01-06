<?php

namespace App\Http\Controllers;

use App\Models\LoaiTaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoaiTaiKhoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id','!=',1)->get();
        return view('admin/management-page/accounttype', ['danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-accounttype');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoaiTaiKhoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenloaitaikhoan' => 'required|max:30',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
            ],
            [
                'tenloaitaikhoan' => 'Tên loại tài khoản',
            ]
        )->validate();

        //Định dạng lại tên loại tài khoản
        $tenLoaiTaiKhoanFormat=trim( $request->input('tenloaitaikhoan'));
        $tontai = LoaiTaiKhoan::where('ten_loai_tai_khoan', 'like', $tenLoaiTaiKhoanFormat)->first();
        if (empty($tontai)) {
            $kTTenMau = str_replace(' ', '', $tenLoaiTaiKhoanFormat);
            $tontai = LoaiTaiKhoan::where('ten_loai_tai_khoan', 'like', $kTTenMau)->first();
            if (empty($tontai)) {
                $loaiTaiKhoan = new LoaiTaiKhoan;
                $loaiTaiKhoan->fill([
                    'ten_loai_tai_khoan' => $tenLoaiTaiKhoanFormat,
                ]);
                if ($loaiTaiKhoan->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm loại tài khoản thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm loại tài khoản không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm loại tài khoản không thành công ! Tên loại tài khoản đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoaiTaiKhoan  $loaiTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function show(LoaiTaiKhoan $loaiTaiKhoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoaiTaiKhoan  $loaiTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function edit(LoaiTaiKhoan $loaiTaiKhoan)
    {
        return view('admin/edit-page/edit-accounttype', ['loaiTaiKhoan' => $loaiTaiKhoan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoaiTaiKhoanRequest  $request
     * @param  \App\Models\LoaiTaiKhoan  $loaiTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoaiTaiKhoan $loaiTaiKhoan)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenloaitaikhoan' => 'required|max:30',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
            ],
            [
                'tenloaitaikhoan' => 'Tên loại tài khoản',
            ]
        )->validate();

        //Định dạng lại tên loại tài khoản
        $tenLoaiTaiKhoanFormat=trim( $request->input('tenloaitaikhoan'));
        $tontai = LoaiTaiKhoan::where('ten_loai_tai_khoan', 'like', $tenLoaiTaiKhoanFormat)->where('id','!=',$loaiTaiKhoan->id)->first();
        if (empty($tontai)) {
            $kTTenMau = str_replace(' ', '', $tenLoaiTaiKhoanFormat);
            $tontai = LoaiTaiKhoan::where('ten_loai_tai_khoan', 'like', $kTTenMau)->where('id','!=',$loaiTaiKhoan->id)->first();
            if (empty($tontai)) {
                $loaiTaiKhoan->fill([
                    'ten_loai_tai_khoan' => $tenLoaiTaiKhoanFormat,
                ]);
                if ($loaiTaiKhoan->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật loại tài khoản thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật loại tài khoản không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật loại tài khoản không thành công ! Tên loại tài khoản đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoaiTaiKhoan  $loaiTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoaiTaiKhoan $loaiTaiKhoan)
    {
        if ($loaiTaiKhoan->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa loại tài khoản thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa loại tài khoản không thành công !');
    }
}
