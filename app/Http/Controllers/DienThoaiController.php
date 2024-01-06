<?php

namespace App\Http\Controllers;

use App\Models\DienThoai;
use App\Models\ChiTietDienThoai;
use App\Models\HinhAnhChungCuaDienThoai;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DienThoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachDienThoai = DienThoai::join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->select('dien_thoais.*', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        return view('admin/management-page/product', ['danhSachDienThoai' => $danhSachDienThoai]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $danhSachThuongHieu = ThuongHieu::all();
        return view('admin/add-page/add-product', ['danhSachThuongHieu' => $danhSachThuongHieu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDienThoaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Kiểm tra id thương hiệu
        $danhSachThuongHieu = ThuongHieu::all();
        $chuoiIdTH = '';
        $dem = 0;
        foreach ($danhSachThuongHieu as $tp) {
            if ($dem == 0) {
                $chuoiIdTH = $tp->id;
            } else {
                $chuoiIdTH = $chuoiIdTH . ',' . $tp->id;
            }
            $dem++;
        }

        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'tensanpham' => 'required|max:100',
                'hinhanhdaidien' => 'mimes:jpeg,jpg,png',
                'hinhanhthongsokythuat' => 'mimes:jpeg,jpg,png',
                'hinhanhmohop' => 'mimes:jpeg,jpg,png',
                'thuonghieuid' => 'required|in:' . $chuoiIdTH,
                'mota' => 'max:500'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !'
            ],
            [
                'tensanpham' => 'Tên sản phẩm',
                'hinhanhdaidien' => 'Hình ảnh đại diện',
                'hinhanhthongsokythuat' => 'Hình ảnh thông số kỹ thuật',
                'hinhanhmohop' => 'Hình ảnh mở hộp',
                'thuonghieuid' => 'Thương hiệu',
                'mota' => 'Mô tả'
            ]
        )->validate();

        //Định dạng lại tên sản phẩm
        $sanPhamFormat = trim($request->input('tensanpham'));
        $tontai = DienThoai::where('ten_san_pham', 'like', $sanPhamFormat)->first();
        if (empty($tontai)) {
            $kTTenSanPham = str_replace(' ', '', $sanPhamFormat);
            $tontai = DienThoai::where('ten_san_pham', 'like', $kTTenSanPham)->first();
            if (empty($tontai)) {
                //Tạo sản phẩm
                $dienThoai = new DienThoai();
                $dienThoai->fill([
                    'ten_san_pham' => $request->input('tensanpham'),
                    'mo_ta' => $request->input('mota'),
                    'thuong_hieu_id' => $request->input('thuonghieuid'),
                    'trang_thai' => 1
                ]);
                if ($dienThoai->save() == true) {
                    //Lấy tên thương hiệu
                    $tenThuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
                        ->select('ten_thuong_hieu')
                        ->first();

                    //Tạo ảnh đại diện cho sản phẩm
                    $hinhAnhDaiDien = new HinhAnhChungCuaDienThoai();
                    $hinhAnhDaiDien->fill([
                        'dien_thoai_id' => $dienThoai->id,
                        'hinh_anh' => '',
                        'loai_hinh' => 0, //Hình đại diện
                    ]);
                    if ($request->hasFile('hinhanhdaidien')) {
                        $request->file('hinhanhdaidien')->storeAs('public/images/' . $tenThuongHieu . '/' . $dienThoai->ten_san_pham, $request->file('hinhanhdaidien')->getClientOriginalName());
                        $hinhAnhDaiDien->hinh_anh = $tenThuongHieu . '/' . $dienThoai->ten_san_pham . $request->file('hinhanhdaidien')->getClientOriginalName();
                    } else {
                        $hinhAnhDaiDien->hinh_anh = 'default/default.png';
                    }

                    if ($hinhAnhDaiDien->save() == true) {
                        //Tạo ảnh mở hộp cho sản phẩm
                        $hinhAnhMoHop = new HinhAnhChungCuaDienThoai();
                        $hinhAnhMoHop->fill([
                            'dien_thoai_id' => $dienThoai->id,
                            'hinh_anh' => '',
                            'loai_hinh' => 1, //Hình mở hộp
                        ]);
                        if ($request->hasFile('hinhanhmohop')) {
                            $request->file('hinhanhmohop')->storeAs('public/images/' . $tenThuongHieu . '/' . $dienThoai->ten_san_pham, $request->file('hinhanhmohop')->getClientOriginalName());
                            $hinhAnhMoHop->hinh_anh = $tenThuongHieu . '/' . $dienThoai->ten_san_pham . $request->file('hinhanhmohop')->getClientOriginalName();
                        } else {
                            $hinhAnhMoHop->hinh_anh = 'default/default.png';
                        }
                        if ($hinhAnhMoHop->save() == true) {
                            //Tạo ảnh thông số kỹ thuật cho sản phẩm
                            $hinhAnhThongSoKyThuat = new HinhAnhChungCuaDienThoai();
                            $hinhAnhThongSoKyThuat->fill([
                                'dien_thoai_id' => $dienThoai->id,
                                'hinh_anh' => '',
                                'loai_hinh' => 2, //Hình thông số kỹ thuật
                            ]);
                            if ($request->hasFile('hinhanhthongsokythuat')) {
                                $request->file('hinhanhthongsokythuat')->storeAs('public/images/' . $tenThuongHieu . '/' . $dienThoai->ten_san_pham, $request->file('hinhanhthongsokythuat')->getClientOriginalName());
                                $hinhAnhThongSoKyThuat->hinh_anh = $tenThuongHieu . '/' . $dienThoai->ten_san_pham . $request->file('hinhanhthongsokythuat')->getClientOriginalName();
                            } else {
                                $hinhAnhThongSoKyThuat->hinh_anh = 'default/default.png';
                            }
                            if ($hinhAnhThongSoKyThuat->save() == true) {
                                return redirect()->back()->with('thongbao', 'Thêm sản phẩm thành công !');
                            }
                            return redirect()->back()->with('thongbao', 'Thêm sản phẩm không thành công !');
                        }
                        return redirect()->back()->with('thongbao', 'Thêm sản phẩm không thành công !');
                    }
                    return redirect()->back()->with('thongbao', 'Thêm sản phẩm không thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm sản phẩm không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm sản phẩm không thành công ! Tên sản phẩm đã tồn tại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DienThoai  $dienThoai
     * @return \Illuminate\Http\Response
     */
    public function show(DienThoai $dienThoai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DienThoai  $dienThoai
     * @return \Illuminate\Http\Response
     */
    public function edit(DienThoai $dienThoai)
    {
        //Lấy các hình ảnh đại diện, mở hộp, thông số kỹ thuật của sản phẩm
        $hinhAnhDaiDien = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoai->id)
            ->where('loai_hinh', '=', 0)
            ->first();
        $hinhAnhMoHop = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoai->id)
            ->where('loai_hinh', '=', 1)
            ->first();
        $hinhAnhThongSoKyThuat = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoai->id)
            ->where('loai_hinh', '=', 2)
            ->first();

        //Lấy danh sách chi tiết sản phẩm
        $danhSachChiTiet = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->where('dien_thoai_id', '=', $dienThoai->id)
            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
            ->get();

        //Lấy danh sách thương hiệu
        $danhSachThuongHieu = ThuongHieu::all();
        return view('admin/edit-page/edit-product', ['dienThoai' => $dienThoai, 'danhSachChiTiet' => $danhSachChiTiet, 'danhSachThuongHieu' => $danhSachThuongHieu, 'hinhAnhDaiDien' => $hinhAnhDaiDien, 'hinhAnhMoHop' => $hinhAnhMoHop, 'hinhAnhThongSoKyThuat' => $hinhAnhThongSoKyThuat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDienThoaiRequest  $request
     * @param  \App\Models\DienThoai  $dienThoai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DienThoai $dienThoai)
    {
        // Kiểm tra id thương hiệu
        $danhSachThuongHieu = ThuongHieu::all();
        $chuoiIdTH = '';
        $dem = 0;
        foreach ($danhSachThuongHieu as $tp) {
            if ($dem == 0) {
                $chuoiIdTH = $tp->id;
            } else {
                $chuoiIdTH = $chuoiIdTH . ',' . $tp->id;
            }
            $dem++;
        }

        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'tensanpham' => 'required|max:100',
                'hinhanhdaidien' => 'mimes:jpeg,jpg,png',
                'hinhanhthongsokythuat' => 'mimes:jpeg,jpg,png',
                'hinhanhmohop' => 'mimes:jpeg,jpg,png',
                'thuonghieuid' => 'required|in:' . $chuoiIdTH,
                'mota' => 'max:500'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !'
            ],
            [
                'tensanpham' => 'Tên sản phẩm',
                'hinhanhdaidien' => 'Hình ảnh đại diện',
                'hinhanhthongsokythuat' => 'Hình ảnh thông số kỹ thuật',
                'hinhanhmohop' => 'Hình ảnh mở hộp',
                'thuonghieuid' => 'Thương hiệu',
                'mota' => 'Mô tả'
            ]
        )->validate();

        //Định dạng lại tên sản phẩm
        $sanPhamFormat = trim($request->input('tensanpham'));
        $tontai = DienThoai::where('ten_san_pham', 'like', $sanPhamFormat)->where('id', '!=', $dienThoai->id)->first();
        if (empty($tontai)) {
            $kTTenSanPham = str_replace(' ', '', $sanPhamFormat);
            $tontai = DienThoai::where('ten_san_pham', 'like', $kTTenSanPham)->where('id', '!=', $dienThoai->id)->first();
            if (empty($tontai)) {
                //Cập nhật sản phẩm
                $dienThoai->fill([
                    'ten_san_pham' => $request->input('tensanpham'),
                    'mo_ta' => $request->input('mota'),
                    'thuong_hieu_id' => $request->input('thuonghieuid'),
                ]);
                if ($dienThoai->save() == true) {
                    //Lấy tên thương hiệu
                    $tenThuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
                        ->select('ten_thuong_hieu')
                        ->first();

                    //Cập nhật ảnh đại diện cho sản phẩm
                    $hinhAnhDaiDien = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoai->id)
                        ->where('loai_hinh', '=', 0)
                        ->first();
                    if ($request->hasFile('hinhanhdaidien')) {
                        $request->file('hinhanhdaidien')->storeAs('public/images/' . $tenThuongHieu . '/' . $dienThoai->ten_san_pham, $request->file('hinhanhdaidien')->getClientOriginalName());
                        $hinhAnhDaiDien->hinh_anh = $tenThuongHieu . '/' . $dienThoai->ten_san_pham . $request->file('hinhanhdaidien')->getClientOriginalName();
                    }
                    if ($hinhAnhDaiDien->save() == true) {
                        //Cập nhật ảnh mở hộp cho sản phẩm
                        $hinhAnhMoHop = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoai->id)
                            ->where('loai_hinh', '=', 1)
                            ->first();
                        if ($request->hasFile('hinhanhmohop')) {
                            $request->file('hinhanhmohop')->storeAs('public/images/' . $tenThuongHieu . '/' . $dienThoai->ten_san_pham, $request->file('hinhanhmohop')->getClientOriginalName());
                            $hinhAnhMoHop->hinh_anh = $tenThuongHieu . '/' . $dienThoai->ten_san_pham . $request->file('hinhanhmohop')->getClientOriginalName();
                        }
                        if ($hinhAnhMoHop->save() == true) {
                            //Cập nhật ảnh thông số kỹ thuật cho sản phẩm
                            $hinhAnhThongSoKyThuat = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoai->id)
                                ->where('loai_hinh', '=', 2)
                                ->first();
                            if ($request->hasFile('hinhanhthongsokythuat')) {
                                $request->file('hinhanhthongsokythuat')->storeAs('public/images/' . $tenThuongHieu . '/' . $dienThoai->ten_san_pham, $request->file('hinhanhthongsokythuat')->getClientOriginalName());
                                $hinhAnhThongSoKyThuat->hinh_anh = $tenThuongHieu . '/' . $dienThoai->ten_san_pham . $request->file('hinhanhthongsokythuat')->getClientOriginalName();
                            }
                            if ($hinhAnhThongSoKyThuat->save() == true) {
                                return redirect()->back()->with('thongbao', 'Cập nhật sản phẩm thành công !');
                            }
                            return redirect()->back()->with('thongbao', 'Cập nhật sản phẩm không thành công !');
                        }
                        return redirect()->back()->with('thongbao', 'Cập nhật sản phẩm không thành công !');
                    }
                    return redirect()->back()->with('thongbao', 'Cập nhật sản phẩm không thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật sản phẩm không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật sản phẩm không thành công ! Tên sản phẩm đã tồn tại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DienThoai  $dienThoai
     * @return \Illuminate\Http\Response
     */
    public function destroy(DienThoai $dienThoai)
    {
        if ($dienThoai->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa điện thoại thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa điện thoại không thành công !');
    }

    public function thayDoiTrangThai($sanPhamId)
    {
        $dienThoai = DienThoai::where('id', '=', $sanPhamId)->first();
        if ($dienThoai->trang_thai == 0) {
            if ($dienThoai->update(['trang_thai' => 1]) == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật trạng thái sản phẩm thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái sản phẩm không thành công !');
        } else {
            if ($dienThoai->update(['trang_thai' => 0]) == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật trạng thái sản phẩm thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái sản phẩm không thành công !');
        }
    }
}
