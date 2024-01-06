<?php

namespace App\Http\Controllers;

use App\Models\Kho;
use App\Models\ChiTietKho;
use App\Models\ChiTietDienThoai;
use App\Models\ChiTietDonHang;
use App\Models\SanPhamPhanBo;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\CuaHang;
use App\Models\DonHang;
use App\Models\TaiKhoan;
use App\Models\ThongTinTaiKhoan;
use App\Models\NhanVien;
use App\Models\HinhAnhMauSacCuaDienThoai;
use App\Models\BacTaiKhoan;
use App\Models\PhieuGiamGia;
use App\Mail\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DonHangController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDonHangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function show(DonHang $donHang)
    {
        $danhSachChiTiet = ChiTietDonHang::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_khos.chi_tiet_dien_thoai_id')
            ->join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('chi_tiet_don_hangs.don_hang_id', '=', $donHang->id)
            ->select('chi_tiet_don_hangs.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        return view('admin/management-page/detail-order', ['danhSachChiTiet' => $danhSachChiTiet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function edit(DonHang $donHang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDonHangRequest  $request
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DonHang $donHang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DonHang  $donHang
     * @return \Illuminate\Http\Response
     */
    public function destroy(DonHang $donHang)
    {
        //
    }

    public function indexDonHang($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if (empty($taiKhoan)) {
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachDonHang = DonHang::orderBy('created_at','DESC')->get();
            foreach ($danhSachDonHang as $tp) {
                $tp->ngay_tao = Carbon::createFromFormat('Y-m-d', $tp->ngay_tao)->format('d/m/Y');
                if ($tp->ngay_giao != null) {
                    $tp->ngay_giao = Carbon::createFromFormat('Y-m-d', $tp->ngay_giao)->format('d/m/Y');
                }
            }
            return view('admin/management-page/order', ['danhSachDonHang' => $danhSachDonHang]);
        } else {
            $nhanVien = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            if ($nhanVien->kho_id != 1) {
                $danhSachDonHang = DonHang::where('cua_hang_id', '=', null)->orderBy('created_at','DESC')->get();
                foreach ($danhSachDonHang as $tp) {
                    $tp->ngay_tao = Carbon::createFromFormat('Y-m-d', $tp->ngay_tao)->format('d/m/Y');
                    if ($tp->ngay_giao != null) {
                        $tp->ngay_giao = Carbon::createFromFormat('Y-m-d', $tp->ngay_giao)->format('d/m/Y');
                    }
                }
                return view('admin/management-page/order', ['danhSachDonHang' => $danhSachDonHang]);
            } else {
                $danhSachDonHang = DonHang::where('cua_hang_id', '=', $nhanVien->cua_hang_id)->orderBy('created_at','DESC')->get();
                foreach ($danhSachDonHang as $tp) {
                    $tp->ngay_tao = Carbon::createFromFormat('Y-m-d', $tp->ngay_tao)->format('d/m/Y');
                    if ($tp->ngay_giao != null) {
                        $tp->ngay_giao = Carbon::createFromFormat('Y-m-d', $tp->ngay_giao)->format('d/m/Y');
                    }
                }
                return view('admin/management-page/order', ['danhSachDonHang' => $danhSachDonHang]);
            }
        }
    }

    public function showDonHang($maDonHang)
    {
        $danhSachChiTiet = ChiTietDonHang::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_don_hangs.chi_tiet_dien_thoai_id')
            ->join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)
            ->select('chi_tiet_don_hangs.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        return view('admin/management-page/detail-order', ['danhSachChiTiet' => $danhSachChiTiet]);
    }

    public function capNhatTrangThaiDH(Request $request, $maDonHang)
    {
        $donHang = DonHang::where('ma_don_hang', '=', $maDonHang)->first();
        if ($request->trangthaidonhang == null) {
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đơn hàng không thành công !');
        }
        if ($request->trangthaidonhang == 3) {
            $donHang->fill([
                'ngay_giao' => Carbon::now('Asia/Ho_Chi_Minh'),
                'trang_thai_thanh_toan' => 1,
            ]);
            $danhSachChiTietDH = ChiTietDonHang::where('don_hang_id', '=', $donHang->ma_don_hang)->get();
            $tongTien = 0;
            foreach ($danhSachChiTietDH as $ct) {
                $tongTien += $ct->gia_giam * $ct->so_luong;
            }
            $diem = $tongTien / 10000;
            $taiKhoan = TaiKhoan::where('id', '=', $donHang->tai_khoan_khach_hang_id)->first();
            $taiKhoan->fill([
                'diem_thuong' => $taiKhoan->diem_thuong + $diem,
            ]);
            $danhSachBacTaiKhoan = BacTaiKhoan::all();
            $phanTramGiam = 0.05;
            foreach ($danhSachBacTaiKhoan as $tp) {
                if ($taiKhoan->diem_thuong > 10000 && $taiKhoan->bac_tai_khoan_id == $tp->id) {
                    $phieuGiamGia = new PhieuGiamGia();
                    $phieuGiamGia->fill([
                        'code' => Str::random(8),
                        'phan_tram_giam' => 0.2,
                        'ngay_bat_dau' => Carbon::now('Asia/Ho_Chi_Minh'),
                        'ngay_het_han' => Carbon::now('Asia/Ho_Chi_Minh')->addYear(),
                        'trang_thai' => 1,
                    ]);
                    $phieuGiamGia->save();
                    $details = [
                        'code' => $phieuGiamGia->code,
                        'ten_bac' => '',
                        'phan_tram_giam' => $phieuGiamGia->phan_tram_giam * 100,
                        'loai' => 2,
                    ];
                    $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', $taiKhoan->id)->first();
                    Mail::to($thongTinTaiKhoan->email)->send(new Voucher($details));
                }
                if ($taiKhoan->diem_thuong >= $tp->han_muc && $taiKhoan->bac_tai_khoan_id < $tp->id) {
                    $taiKhoan->bac_tai_khoan_id = $tp->id;
                    $bacTaiKhoan = BacTaiKhoan::where('id', '=', $taiKhoan->bac_tai_khoan_id)->first();
                    if ($taiKhoan->diem_thuong >= 100) {
                        $phieuGiamGia = new PhieuGiamGia();
                        $phieuGiamGia->fill([
                            'code' => Str::random(8),
                            'phan_tram_giam' => $phanTramGiam,
                            'ngay_bat_dau' => Carbon::now('Asia/Ho_Chi_Minh'),
                            'ngay_het_han' => Carbon::now('Asia/Ho_Chi_Minh')->addYear(),
                            'trang_thai' => 1,
                        ]);
                        $phieuGiamGia->save();
                        $details = [
                            'code' => $phieuGiamGia->code,
                            'ten_bac' => $bacTaiKhoan->ten_bac_tai_khoan,
                            'phan_tram_giam' => $phieuGiamGia->phan_tram_giam * 100,
                            'loai' => 1,
                        ];
                        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', $taiKhoan->id)->first();
                        Mail::to($thongTinTaiKhoan->email)->send(new Voucher($details));
                    }
                }
                $phanTramGiam = $phanTramGiam + 0.05;
            }
            $taiKhoan->save();
        }
        if ($request->trangthaidonhang == 4) {
            if ($donHang->cua_hang_id == null) {
                $danhSachChiTietDH = ChiTietDonHang::where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)->get();
                $kho = Kho::where('id', '!=', 1)->first();
                foreach ($danhSachChiTietDH as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp->chi_tiet_dien_thoai_id)
                        ->first();
                    $chiTietKho->fill([
                        'so_luong' => $chiTietKho->so_luong + $tp->so_luong,
                    ]);
                    $chiTietKho->save();
                }
            } else {
                $danhSachChiTietDH = ChiTietDonHang::where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)->get();
                $cuaHang = CuaHang::where('id', '=', $donHang->cua_hang_id)->first();
                foreach ($danhSachChiTietDH as $tp) {
                    $sanPhamPhanBo = SanPhamPhanBo::where('cua_hang_id', '=', $cuaHang->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp->chi_tiet_dien_thoai_id)
                        ->first();
                    $sanPhamPhanBo->fill([
                        'so_luong' => $sanPhamPhanBo->so_luong + $tp->so_luong,
                    ]);
                    $sanPhamPhanBo->save();
                }
            }
        }
        $donHang->fill([
            'tai_khoan_nhan_vien_id' => Auth::user()->id,
            'trang_thai_don_hang' => $request->trangthaidonhang,
        ]);

        if ($donHang->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đơn hàng thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đơn hàng không thành công !');
    }

    public function indexDonHangKH()
    {
        $taiKhoan = TaiKhoan::where('username', '=', Auth::user()->username)->first();
        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', $taiKhoan->id)->first();
        $danhSachDonHang = DonHang::where('tai_khoan_khach_hang_id', '=', $taiKhoan->id)->get();
        foreach ($danhSachDonHang as $tp) {
            $tp->ngay_tao = Carbon::createFromFormat('Y-m-d', $tp->ngay_tao)->format('d/m/Y');
            if ($tp->ngay_giao != null) {
                $tp->ngay_giao = Carbon::createFromFormat('Y-m-d', $tp->ngay_giao)->format('d/m/Y');
            }
            $danhSachChiTietDH = ChiTietDonHang::where('don_hang_id', '=', $tp->ma_don_hang)->get();
            $tongTien = 0;
            $tongTienChuaGiam = 0;
            foreach ($danhSachChiTietDH as $ct) {
                $tongTien += $ct->gia_giam * $ct->so_luong;
                $tongTienChuaGiam += $ct->gia * $ct->so_luong;
            }
            $tp->tong_tien = $tongTien;
            $tp->tong_tien_chua_giam = $tongTienChuaGiam;
            $tp->giam = $tongTienChuaGiam - $tongTien;
        }
        return view('user/order-management', ['danhSachDonHang' => $danhSachDonHang, 'thongTinTaiKhoan' => $thongTinTaiKhoan]);
    }

    public function showDonHangKH($maDonHang)
    {
        $taiKhoan = TaiKhoan::where('username', '=', Auth::user()->username)->first();
        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', $taiKhoan->id)->first();
        $donHang = DonHang::where('ma_don_hang', '=', $maDonHang)->first();
        if ($donHang->ngay_giao != null) {
            $donHang->ngay_giao = Carbon::createFromFormat('Y-m-d', $donHang->ngay_giao)->format('d/m/Y');
        }
        $danhSachChiTietDH = ChiTietDonHang::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_don_hangs.chi_tiet_dien_thoai_id')
            ->join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)
            ->select('chi_tiet_don_hangs.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();

        $tongTien = 0;
        foreach ($danhSachChiTietDH as $tp) {
            $chiTietDienThoai = ChiTietDienThoai::where('id', '=', $tp->chi_tiet_dien_thoai_id)->first();
            $hinhAnhMauSac = HinhAnhMauSacCuaDienThoai::where('dien_thoai_id', '=', $chiTietDienThoai->dien_thoai_id)
                ->where('mau_sac_id', '=', $chiTietDienThoai->mau_sac_id)
                ->where('hinh_anh_dai_dien', '=', 1)
                ->first();
            // dd($chiTietDienThoai->id);
            $tp->hinh_anh = $hinhAnhMauSac->hinh_anh;
            $tp->dien_thoai_id = $chiTietDienThoai->dien_thoai_id;
            $tongTien += $tp->gia_giam * $tp->so_luong;
        }
        return view('user/order-detail', ['danhSachChiTietDH' => $danhSachChiTietDH, 'donHang' => $donHang, 'thongTinTaiKhoan' => $thongTinTaiKhoan, 'tongTien' => $tongTien]);
    }

    public function huyDonHang($maDonHang)
    {
        $donHang = DonHang::where('ma_don_hang', '=', $maDonHang)->first();
        $donHang->fill([
            'trang_thai_don_hang' => 4,
        ]);
        $donHang->save();
        if ($donHang->cua_hang_id == null) {
            $danhSachChiTietDH = ChiTietDonHang::where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)->get();
            $kho = Kho::where('id', '!=', 1)->first();
            foreach ($danhSachChiTietDH as $tp) {
                $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                    ->where('chi_tiet_dien_thoai_id', '=', $tp->chi_tiet_dien_thoai_id)
                    ->first();
                $chiTietKho->fill([
                    'so_luong' => $chiTietKho->so_luong + $tp->so_luong,
                ]);
                $chiTietKho->save();
            }
        } else {
            $danhSachChiTietDH = ChiTietDonHang::where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)->get();
            $cuaHang = CuaHang::where('id', '=', $donHang->cua_hang_id)->first();
            foreach ($danhSachChiTietDH as $tp) {
                $sanPhamPhanBo = SanPhamPhanBo::where('cua_hang_id', '=', $cuaHang->id)
                    ->where('chi_tiet_dien_thoai_id', '=', $tp->chi_tiet_dien_thoai_id)
                    ->first();
                $sanPhamPhanBo->fill([
                    'so_luong' => $sanPhamPhanBo->so_luong + $tp->so_luong,
                ]);
                $sanPhamPhanBo->save();
            }
        }
        return redirect()->back()->with('thongbao', 'Hủy đơn hàng thành công !');
    }

    public function createBill($maDonHang)
    {
        $donHang = DonHang::where('ma_don_hang', '=', $maDonHang)->first();
        $donHang->ngay_tao_hoa_don =  Carbon::createFromFormat('Y-m-d',  Carbon::now('Asia/Ho_Chi_Minh')->toDateString())->format('d/m/Y');
        $danhSachChiTietDH = ChiTietDonHang::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_don_hangs.chi_tiet_dien_thoai_id')
            ->join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('chi_tiet_don_hangs.don_hang_id', '=', $maDonHang)
            ->select('chi_tiet_don_hangs.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        $tongTien = 0;
        foreach ($danhSachChiTietDH as $tp) {
            $chiTietDienThoai = ChiTietDienThoai::where('id', '=', $tp->chi_tiet_dien_thoai_id)->first();
            $hinhAnhMauSac = HinhAnhMauSacCuaDienThoai::where('dien_thoai_id', '=', $chiTietDienThoai->dien_thoai_id)
                ->where('mau_sac_id', '=', $chiTietDienThoai->mau_sac_id)
                ->where('hinh_anh_dai_dien', '=', 1)
                ->first();
            $tp->hinh_anh = $hinhAnhMauSac->hinh_anh;
            $tp->dien_thoai_id = $chiTietDienThoai->dien_thoai_id;
            $tongTien += $tp->gia_giam * $tp->so_luong;
        }
        view()->share('tongTien', $tongTien);
        view()->share('danhSachChiTietDH', $danhSachChiTietDH);
        view()->share('donHang', $donHang);
        ini_set('max_execution_time', '300');
        $pdf = PDF::loadView('pdf/bill', compact($danhSachChiTietDH, $donHang, $tongTien));
        return $pdf->stream();
        // return $pdf->download('HoaDon-TTMobile-' . $maDonHang . '.pdf');
    }
}
