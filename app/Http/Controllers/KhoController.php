<?php

namespace App\Http\Controllers;

use App\Models\Kho;
use App\Models\ChiTietKho;
use App\Models\ChiTietDienThoai;
use App\Models\SanPhamPhanBo;
use App\Models\CuaHang;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KhoController extends Controller
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
        return view('admin/add-page/add-storehouse');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKhoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenkho' => 'required|max:30',
                'diachi' => 'required|max:500',
                'googlemap' => 'required|url|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'url' => ':attribute không phải là Url'
            ],
            [
                'tenkho' => 'Tên kho',
                'diachi' => 'Địa chỉ',
                'googlemap' => 'Url Google Map'
            ]
        )->validate();

        //Định dạng lại tên kho
        $tenFormat = trim($request->input('tenkho'));
        $diaChiFormat = trim($request->input('diachi'));
        $tontai1 = Kho::where('ten_kho', 'like', $tenFormat)->first();
        $tontai2 = Kho::where('dia_chi', 'like', $diaChiFormat)->first();
        $tontai3 = Kho::where('google_map', 'like', $request->input('googlemap'))->first();
        if (empty($tontai1) && empty($tontai2) && empty($tontai3)) {
            $kTTen = str_replace(' ', '', $tenFormat);
            $ktDiaChi = str_replace(' ', '', $diaChiFormat);
            $tontai1 = Kho::where('ten_kho', 'like', $kTTen)->first();
            $tontai2 = Kho::where('dia_chi', 'like', $ktDiaChi)->first();
            if (empty($tontai1) && empty($tontai2)) {
                $kho = new Kho;
                $kho->fill([
                    'ten_kho' => $tenFormat,
                    'dia_chi' => $diaChiFormat,
                    'google_map' =>$request->input('googlemap'),
                ]);
                if ($kho->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm kho thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm kho không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm kho không thành công ! Tên kho hoặc địa chỉ hoặc Url đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kho  $kho
     * @return \Illuminate\Http\Response
     */
    public function show(Kho $kho)
    {
        $danhSachChiTietKho = ChiTietKho::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_khos.chi_tiet_dien_thoai_id')
            ->join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('chi_tiet_khos.kho_id', '=', $kho->id)
            ->select('chi_tiet_khos.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        foreach ($danhSachChiTietKho as $tp) {
            $tp->ngay_nhap = Carbon::createFromFormat('Y-m-d', $tp->ngay_nhap)->format('d/m/Y');
        }

        $danhSachChiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();

        $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
        return view('admin/management-page/detail-storehouse', [
            'danhSachChiTietKho' => $danhSachChiTietKho, 'danhSachChiTietDienThoai' => $danhSachChiTietDienThoai,
            'kho' => $kho, 'danhSachCuaHang' => $danhSachCuaHang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kho  $kho
     * @return \Illuminate\Http\Response
     */
    public function edit(Kho $kho)
    {
        return view('admin/edit-page/edit-storehouse', ['kho' => $kho]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKhoRequest  $request
     * @param  \App\Models\Kho  $kho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kho $kho)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenkho' => 'required|max:30',
                'diachi' => 'required|max:500',
                'googlemap' => 'required|url|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'url' => ':attribute không phải là Url'
            ],
            [
                'tenkho' => 'Tên kho',
                'diachi' => 'Địa chỉ',
                'googlemap' => 'Url Google Map'
            ]
        )->validate();

        //Định dạng lại tên kho
        $tenFormat = trim($request->input('tenkho'));
        $diaChiFormat = trim($request->input('diachi'));
        $tontai1 = Kho::where('ten_kho', 'like', $tenFormat)->where('id', '!=', $kho->id)->first();
        $tontai2 = Kho::where('dia_chi', 'like', $diaChiFormat)->where('id', '!=', $kho->id)->first();
        $tontai3 = Kho::where('google_map', 'like', $request->input('googlemap'))->where('id', '!=', $kho->id)->first();
        if (empty($tontai1) && empty($tontai2) && empty($tontai3)) {
            $kTTen = str_replace(' ', '', $tenFormat);
            $ktDiaChi = str_replace(' ', '', $diaChiFormat);
            $tontai1 = Kho::where('ten_kho', 'like', $kTTen)->first();
            $tontai2 = Kho::where('dia_chi', 'like', $ktDiaChi)->first();
            if (empty($tontai1) || empty($tontai2)) {
                $kho->fill([
                    'ten_kho' => $tenFormat,
                    'dia_chi' => $diaChiFormat,
                    'google_map' =>$request->input('googlemap'),
                ]);
                if ($kho->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật kho thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật kho không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật kho không thành công ! Tên kho hoặc địa chỉ hoặc Url đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kho  $kho
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kho $kho)
    {
        if ($kho->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa kho thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa kho không thành công !');
    }

    public function indexKho($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if(empty($taiKhoan)){
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachKho = Kho::where('id', '!=', 1)->get();
            return view('admin/management-page/storehouse', ['danhSachKho' => $danhSachKho]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 3) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            $danhSachKho = Kho::where('id', '=', $quanLy->kho_id)->get();
            return view('admin/management-page/storehouse', ['danhSachKho' => $danhSachKho]);
        }
    }

    public function phanBoSanPham(Request $request, $chiTietDienThoaiId)
    {
        // Kiểm tra id cửa hàng
        $danhSachCH = CuaHang::All();
        $chuoiIdCH = '';
        $dem = 0;
        foreach ($danhSachCH as $tp) {
            if ($dem == 0) {
                $chuoiIdCH = $tp->id;
            } else {
                $chuoiIdCH = $chuoiIdCH . ',' . $tp->id;
            }
            $dem++;
        }

        $validated = Validator::make(
            $request->all(),
            [
                'soluong' => 'required|integer|min:0|numeric',
                'cuahang' => 'required|in:' . $chuoiIdCH,
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
                'integer' => ':attribute phải là kiểu số nguyên!',
                'in' => ':attribute không đúng với dữ liệu hệ thống !',
            ],
            [
                'soluong' => 'Số lượng',
                'cuahang' => 'Cửa hàng'
            ]
        )->validate();

        $sanPhamPhanBo = SanPhamPhanBo::where('cua_hang_id', '=', $request->input('cuahang'))
            ->where('chi_tiet_dien_thoai_id', '=', $chiTietDienThoaiId)
            ->first();
        $chiTietKho = ChiTietKho::where('kho_id', '=', $request->input('khoid'))
            ->where('chi_tiet_dien_thoai_id', '=', $chiTietDienThoaiId)->first();
        if (empty($sanPhamPhanBo)) {
            $chiTietKho = ChiTietKho::where('kho_id', '=', $request->input('khoid'))
                ->where('chi_tiet_dien_thoai_id', '=', $chiTietDienThoaiId)->first();
            if ($chiTietKho->so_luong >= $request->input('soluong')) {
                $chiTietKho->fill([
                    'so_luong' => $chiTietKho->so_luong - $request->input('soluong'),
                ]);
                $chiTietKho->save();
                $sanPhamPhanBo = new SanPhamPhanBo();
                $sanPhamPhanBo->fill([
                    'cua_hang_id' => $request->input('cuahang'),
                    'so_luong' => $request->input('soluong'),
                    'chi_tiet_dien_thoai_id' => $chiTietDienThoaiId,
                ]);
                if ($sanPhamPhanBo->save() == true) {
                    return redirect()->back()->with('thongbao', 'Phân bố sản phẩm thành công !');
                }
                return redirect()->back()->with('thongbao', 'Phân bố sản phẩm không thành công !');
            }
            return redirect()->back()->with('thongbao', 'Phân bố sản phẩm không thành công ! Số lượng sản phẩm không đủ !');
        }
        // dd($chiTietKho->so_luong - $request->input('soluong'));
        if ($chiTietKho->so_luong >= $request->input('soluong')) {
            $chiTietKho->fill([
                'so_luong' => $chiTietKho->so_luong - $request->input('soluong'),
            ]);
            $chiTietKho->save();
            $sanPhamPhanBo->fill([
                'so_luong' => $sanPhamPhanBo->so_luong + $request->input('soluong'),
            ]);
            if ($sanPhamPhanBo->save() == true) {
                return redirect()->back()->with('thongbao', 'Phân bố sản phẩm thành công !');
            }
            return redirect()->back()->with('thongbao', 'Phân bố sản phẩm không thành công !');
        }
        return redirect()->back()->with('thongbao', 'Phân bố sản phẩm không thành công ! Số lượng sản phẩm không đủ !');
    }
}
