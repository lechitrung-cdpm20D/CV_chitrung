<?php

namespace App\Http\Controllers;

use App\Models\CuaHang;
use App\Models\NhanVien;
use App\Models\SanPhamPhanBo;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuaHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCuaHangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tencuahang' => 'required|max:30',
                'diachi' => 'required|max:500',
                'googlemap' => 'required|url|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'url' => ':attribute không phải là Url'
            ],
            [
                'tencuahang' => 'Tên cửa hàng',
                'diachi' => 'Địa chỉ',
                'googlemap' => 'Url Google Map'
            ]
        )->validate();

        //Định dạng lại tên cửa hàng
        $tenFormat = trim($request->input('tencuahang'));
        $diaChiFormat = trim($request->input('diachi'));
        $tontai1 = CuaHang::where('ten_cua_hang', 'like', $tenFormat)->first();
        $tontai2 = CuaHang::where('dia_chi', 'like', $diaChiFormat)->first();
        $tontai3 = CuaHang::where('google_map', 'like', $request->input('googlemap'))->first();
        if (empty($tontai1) && empty($tontai2) && empty($tontai3)) {
            $kTTen = str_replace(' ', '', $tenFormat);
            $ktDiaChi = str_replace(' ', '', $diaChiFormat);
            $tontai1 = CuaHang::where('ten_cua_hang', 'like', $kTTen)->first();
            $tontai2 = CuaHang::where('dia_chi', 'like', $ktDiaChi)->first();
            if (empty($tontai1) && empty($tontai2)) {
                $cuaHang = new CuaHang;
                $cuaHang->fill([
                    'ten_cua_hang' => $tenFormat,
                    'dia_chi' => $diaChiFormat,
                    'google_map' =>$request->input('googlemap'),
                ]);
                if ($cuaHang->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm cửa hàng thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm cửa hàng không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm cửa hàng không thành công ! Tên cửa hàng hoặc địa chỉ hoặc Url đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CuaHang  $cuaHang
     * @return \Illuminate\Http\Response
     */
    public function show(CuaHang $cuaHang)
    {
        $danhSachSanPhamPhanBo = SanPhamPhanBo::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'san_pham_phan_bos.chi_tiet_dien_thoai_id')
            ->join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('san_pham_phan_bos.cua_hang_id', '=', $cuaHang->id)
            ->select('san_pham_phan_bos.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        return view('admin/management-page/detail-store', [
            'danhSachSanPhamPhanBo' => $danhSachSanPhamPhanBo,'cuaHang' => $cuaHang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CuaHang  $cuaHang
     * @return \Illuminate\Http\Response
     */
    public function edit(CuaHang $cuaHang)
    {
        return view('admin/edit-page/edit-store', ['cuaHang' => $cuaHang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCuaHangRequest  $request
     * @param  \App\Models\CuaHang  $cuaHang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CuaHang $cuaHang)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tencuahang' => 'required|max:30',
                'diachi' => 'required|max:500',
                'googlemap' => 'required|url|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'url' => ':attribute không phải là Url'
            ],
            [
                'tencuahang' => 'Tên cửa hàng',
                'diachi' => 'Địa chỉ',
                'googlemap' => 'Url Google Map'
            ]
        )->validate();

        //Định dạng lại tên cửa hàng
        $tenFormat = trim($request->input('tencuahang'));
        $diaChiFormat = trim($request->input('diachi'));
        $tontai1 = CuaHang::where('ten_cua_hang', 'like', $tenFormat)->where('id', '!=', $cuaHang->id)->first();
        $tontai2 = CuaHang::where('dia_chi', 'like', $diaChiFormat)->where('id', '!=', $cuaHang->id)->first();
        $tontai3 = CuaHang::where('google_map', 'like', $request->input('googlemap'))->where('id', '!=', $cuaHang->id)->first();
        if (empty($tontai1) && empty($tontai2) && empty($tontai3)) {
            $kTTen = str_replace(' ', '', $tenFormat);
            $ktDiaChi = str_replace(' ', '', $diaChiFormat);
            $tontai1 = CuaHang::where('ten_cua_hang', 'like', $kTTen)->where('id', '!=', $cuaHang->id)->first();
            $tontai2 = CuaHang::where('dia_chi', 'like', $ktDiaChi)->where('id', '!=', $cuaHang->id)->first();
            if (empty($tontai1) && empty($tontai2)) {
                $cuaHang->fill([
                    'ten_cua_hang' => $tenFormat,
                    'dia_chi' => $diaChiFormat,
                    'google_map' =>$request->input('googlemap'),
                ]);
                if ($cuaHang->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật cửa hàng thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật cửa hàng không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật cửa hàng không thành công ! Tên cửa hàng hoặc địa chỉ hoặc Url đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CuaHang  $cuaHang
     * @return \Illuminate\Http\Response
     */
    public function destroy(CuaHang $cuaHang)
    {
        if ($cuaHang->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa cửa hàng thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa cửa hàng không thành công !');
    }

    public function indexCuaHang($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if(empty($taiKhoan)){
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
            return view('admin/management-page/store', ['danhSachCuaHang' => $danhSachCuaHang]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 2) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            $danhSachCuaHang = CuaHang::where('id', '=', $quanLy->cua_hang_id)->get();
            return view('admin/management-page/store', ['danhSachCuaHang' => $danhSachCuaHang]);
        }
    }
}
