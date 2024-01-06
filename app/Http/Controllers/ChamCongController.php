<?php

namespace App\Http\Controllers;

use App\Models\ChamCong;
use App\Models\HeSoLuong;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ChamCongController extends Controller
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
     * @param  \App\Http\Requests\StoreChamCongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChamCong  $chamCong
     * @return \Illuminate\Http\Response
     */
    public function show(ChamCong $chamCong)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChamCong  $chamCong
     * @return \Illuminate\Http\Response
     */
    public function edit(ChamCong $chamCong)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChamCongRequest  $request
     * @param  \App\Models\ChamCong  $chamCong
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChamCong $chamCong)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChamCong  $chamCong
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChamCong $chamCong)
    {
        //
    }

    public function indexQuanLyLuong($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if (empty($taiKhoan)) {
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachLuongNhanVien = ChamCong::join('nhan_viens','nhan_viens.id','=','cham_congs.nhan_vien_id')
            ->join('chuc_vus','chuc_vus.id','=','nhan_viens.chuc_vu_id')
            ->join('he_so_luongs','he_so_luongs.ma_hsl','=','cham_congs.he_so_luong_id')
            ->join('phu_caps','phu_caps.ma_phu_cap','=','cham_congs.phu_cap_id')
            ->join('thuongs','thuongs.ma_thuong','=','cham_congs.thuong_id')
            ->select('cham_congs.*','nhan_viens.ho_ten','nhan_viens.cccd','chuc_vus.ten_chuc_vu','he_so_luongs.he_so_luong'
            ,'phu_caps.tien_phu_cap','thuongs.tien_thuong','chuc_vus.luong_co_ban')
            ->get();
            return view('admin/management-page/salary', ['danhSachLuongNhanVien' => $danhSachLuongNhanVien]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 2) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            $danhSachLuongNhanVien = ChamCong::join('nhan_viens','nhan_viens.id','=','cham_congs.nhan_vien_id')
            ->join('chuc_vus','chuc_vus.id','=','nhan_viens.chuc_vu_id')
            ->where('nhan_viens.cua_hang_id','=',$quanLy->cua_hang_id)
            ->select('cham_congs.*','nhan_viens.ho_ten','nhan_viens.cccd','chuc_vus.ten_chuc_vu','he_so_luongs.he_so_luong'
            ,'phu_caps.tien_phu_cap','thuongs.tien_thuong','chuc_vus.luong_co_ban')
            ->get();
            return view('admin/management-page/salary', ['danhSachLuongNhanVien' => $danhSachLuongNhanVien]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 3) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            $danhSachLuongNhanVien = ChamCong::join('nhan_viens','nhan_viens.id','=','cham_congs.nhan_vien_id')
            ->join('chuc_vus','chuc_vus.id','=','nhan_viens.chuc_vu_id')
            ->where('nhan_viens.kho_id','=',$quanLy->kho_id)
            ->select('cham_congs.*','nhan_viens.ho_ten','nhan_viens.cccd','chuc_vus.ten_chuc_vu','he_so_luongs.he_so_luong'
            ,'phu_caps.tien_phu_cap','thuongs.tien_thuong','chuc_vus.luong_co_ban')
            ->get();
            return view('admin/management-page/salary', ['danhSachLuongNhanVien' => $danhSachLuongNhanVien]);
        }
    }

    public function chamCongNhanVien(Request $request, $nhanVienId)
    {
        $danhSachHSL = HeSoLuong::All();
        $chuoiIdHeSoLuong = '';
        $dem = 0;
        foreach ($danhSachHSL as $tp) {
            if ($dem == 0) {
                $chuoiIdHeSoLuong = $tp->ma_hsl;
            } else {
                $chuoiIdHeSoLuong = $chuoiIdHeSoLuong . ',' . $tp->ma_hsl;
            }
            $dem++;
        }

        $validated = Validator::make(
            $request->all(),
            [
                'hesoluong' => 'required|in:' . $chuoiIdHeSoLuong,
                'songaylamviec' => 'required|numeric|max:26|min:0',
                'ungtruoc' => 'required|numeric|min:0|max:500000',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute vượt quá s:attribute cho phép !',
                'min' => ':attribute phải lớn hơn 0 !',
                'numeric' => ':attribute phải là kiểu số !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !',
            ],
            [
                'hesoluong' => 'Hệ số lương',
                'songaylamviec' => 'Số ngày làm việc',
                'ungtruoc' => 'Ứng trước',
            ]
        )->validate();

        $thang = Carbon::now()->format('m');
        $nam = Carbon::now()->format('Y');
        $ktChamCong = ChamCong::where('nhan_vien_id', '=', $nhanVienId)
            ->where('thang', '=', $thang)
            ->where('nam', '=', $nam)
            ->first();

        if (empty($ktChamCong)) {
            $chamCong = new ChamCong;
            $chamCong->fill([
                'nhan_vien_id' => $nhanVienId,
                'he_so_luong_id' => $request->input('hesoluong'),
                'thuong_id' => $request->input('thuong'),
                'phu_cap_id' => $request->input('phucap'),
                'thang' => $thang,
                'nam' => $nam,
                'so_ngay_lam_viec' => $request->input('songaylamviec'),
                'ung_truoc' => $request->input('ungtruoc'),
            ]);
            if ($chamCong->save() == true) {
                return redirect()->back()->with('thongbao', 'Chấm công nhân viên thành công !');
            }
            return redirect()->back()->with('thongbao', 'Chấm công nhân viên không thành công !');
        }
        return redirect()->back()->with('thongbao', 'Chấm công nhân viên không thành công ! Nhân viên đã được chấm công tháng này !');
    }
}
