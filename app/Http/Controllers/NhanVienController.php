<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use App\Models\NhanVien;
use App\Models\ChucVu;
use App\Models\CuaHang;
use App\Models\Kho;
use App\Models\Thuong;
use App\Models\PhuCap;
use App\Models\HeSoLuong;
use App\Models\LoaiTaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class NhanVienController extends Controller
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
     * @param  \App\Http\Requests\StoreNhanVienRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $request->input('token'))->first();
        if (empty($taiKhoan)) {
            return redirect()->back()->with('thongbao', 'Thêm không thành công ! Token đã bị chỉnh sửa !');
        }
        $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->get();
        // Kiểm tra id chức vụ
        $danhSachCV = ChucVu::All();
        $chuoiIdCV = '';
        $dem = 0;
        foreach ($danhSachCV as $tp) {
            if ($dem == 0) {
                $chuoiIdCV = $tp->id;
            } else {
                $chuoiIdCV = $chuoiIdCV . ',' . $tp->id;
            }
            $dem++;
        }

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

        // Kiểm tra id kho
        $danhSachKho = Kho::All();
        $chuoiIdKho = '';
        $dem = 0;
        foreach ($danhSachKho as $tp) {
            if ($dem == 0) {
                $chuoiIdKho = $tp->id;
            } else {
                $chuoiIdKho = $chuoiIdKho . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id tài khoản
        $danhSachTK = TaiKhoan::where('id', '!=', 1)->get();
        $chuoiIdTK = '';
        $dem = 0;
        foreach ($danhSachTK as $tp) {
            if ($dem == 0) {
                $chuoiIdTK = $tp->id;
            } else {
                $chuoiIdTK = $chuoiIdTK . ',' . $tp->id;
            }
            $dem++;
        }

        $validated = Validator::make(
            $request->all(),
            [
                'hoten' => 'required|max:30',
                'diachi' => 'required|max:500',
                'ngaysinh' => 'required|date|before:-18 years',
                'gioitinh' => 'required|in:1,0',
                'sdt' => 'required|regex:/(09)[0-9]{8}/',
                'cccd' => 'required|regex:/[0-9]{12}/',
                'bhxh' => 'required|regex:/[0-9]{10}/',
                'chucvu' => 'required|in:' . $chuoiIdCV,
                'cuahang' => 'required|in:' . $chuoiIdCH,
                'kho' => 'required|in:' . $chuoiIdKho,
                'taikhoan' => 'required|in:' . $chuoiIdTK,
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !',
                'regex' => ':attribute không hợp lệ ! Vui lòng kiểm tra lại !',
                'date' => ':attribute không đúng kiểu dữ liệu !',
                'before' => ':attribute không hợp lệ ! Chưa đủ tuổi !',
            ],
            [
                'hoten' => 'Họ tên',
                'diachi' => 'Địa chỉ',
                'ngaysinh' => 'Ngày sinh',
                'gioitinh' => 'Giới tính',
                'sdt' => 'Số điện thoại',
                'cccd' => 'Căn cước công dân',
                'bhxh' => 'Bảo hiểm xã hội',
                'chucvu' => 'Chức vụ',
                'cuahang' => 'Cửa hàng',
                'kho' => 'Kho',
                'taikhoan' => 'Tài khoản',
            ]
        )->validate();
        //Kiểm tra tài khoản
        $ktTaiKhoanSuDung = NhanVien::where('tai_khoan_id', '=', $request->input('taikhoan'))->first();
        if (!empty($ktTaiKhoanSuDung)) {
            $taiKhoan = TaiKhoan::where('id', '=', $request->input('taikhoan'))->first();
            return redirect()->back()->with('thongbao', 'Tài khoản' . $taiKhoan->username . 'đã được sử dụng!');
        }
        //Kiểm tra cccd
        $ktCCCDSuDung = NhanVien::where('cccd', '=', $request->input('cccd'))->first();
        if (!empty($ktCCCDSuDung)) {
            return redirect()->back()->with('thongbao', 'Căn cước công dân đã tồn tại!');
        }

        $nhanVien = new NhanVien;
        $nhanVien->fill([
            'chuc_vu_id' => $request->input('chucvu'),
            'quan_ly_id' => $quanLy->id,
            'tai_khoan_id' => $request->input('taikhoan'),
            'cua_hang_id' => $request->input('cuahang'),
            'kho_id' => $request->input('kho'),
            'ho_ten' => $request->input('hoten'),
            'dia_chi' => $request->input('diachi'),
            'ngay_sinh' => $request->input('ngaysinh'),
            'gioi_tinh' => $request->input('gioitinh'),
            'so_dien_thoai' => $request->input('sdt'),
            'cccd' => $request->input('cccd'),
            'bhxh' => $request->input('bhxh'),
        ]);
        if ($nhanVien->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm nhân viên thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm nhân viên không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function show(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function edit(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNhanVienRequest  $request
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NhanVien $nhanVien)
    {
        // Kiểm tra id chức vụ
        $danhSachCV = ChucVu::All();
        $chuoiIdCV = '';
        $dem = 0;
        foreach ($danhSachCV as $tp) {
            if ($dem == 0) {
                $chuoiIdCV = $tp->id;
            } else {
                $chuoiIdCV = $chuoiIdCV . ',' . $tp->id;
            }
            $dem++;
        }

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

        // Kiểm tra id kho
        $danhSachKho = Kho::All();
        $chuoiIdKho = '';
        $dem = 0;
        foreach ($danhSachKho as $tp) {
            if ($dem == 0) {
                $chuoiIdKho = $tp->id;
            } else {
                $chuoiIdKho = $chuoiIdKho . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id tài khoản
        $danhSachTK = TaiKhoan::where('id', '!=', 1)->get();
        $chuoiIdTK = '';
        $dem = 0;
        foreach ($danhSachTK as $tp) {
            if ($dem == 0) {
                $chuoiIdTK = $tp->id;
            } else {
                $chuoiIdTK = $chuoiIdTK . ',' . $tp->id;
            }
            $dem++;
        }

        $validated = Validator::make(
            $request->all(),
            [
                'hoten' => 'required|max:30',
                'diachi' => 'required|max:500',
                'ngaysinh' => 'required|date|before:-18 years',
                'gioitinh' => 'required|in:1,0',
                'sdt' => 'required|regex:/(09)[0-9]{8}/',
                'cccd' => 'required|regex:/[0-9]{12}/',
                'bhxh' => 'required|regex:/[0-9]{10}/',
                'chucvu' => 'required|in:' . $chuoiIdCV,
                'cuahang' => 'required|in:' . $chuoiIdCH,
                'kho' => 'required|in:' . $chuoiIdKho,
                'taikhoan' => 'required|in:' . $chuoiIdTK,
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !',
                'regex' => ':attribute không hợp lệ ! Vui lòng kiểm tra lại !',
                'date' => ':attribute không đúng kiểu dữ liệu !',
                'before' => ':attribute không hợp lệ ! Chưa đủ tuổi !',
            ],
            [
                'hoten' => 'Họ tên',
                'diachi' => 'Địa chỉ',
                'ngaysinh' => 'Ngày sinh',
                'gioitinh' => 'Giới tính',
                'sdt' => 'Số điện thoại',
                'cccd' => 'Căn cước công dân',
                'bhxh' => 'Bảo hiểm xã hội',
                'chucvu' => 'Chức vụ',
                'cuahang' => 'Cửa hàng',
                'kho' => 'Kho',
                'taikhoan' => 'Tài khoản',
            ]
        )->validate();
        //Kiểm tra tài khoản
        $ktTaiKhoanSuDung = NhanVien::where('tai_khoan_id', '=', $request->input('taikhoan'))->where('id', '!=', $nhanVien->id)->first();
        if (!empty($ktTaiKhoanSuDung)) {
            $taiKhoan = TaiKhoan::where('id', '=', $request->input('taikhoan'))->first();
            return redirect()->back()->with('thongbao', 'Tài khoản' . $taiKhoan->username . 'đã được sử dụng bởi nhân viên khác!');
        }
        //Kiểm tra cccd
        $ktCCCDSuDung = NhanVien::where('cccd', '=', $request->input('cccd'))->where('id', '!=', $nhanVien->id)->first();
        if (!empty($ktCCCDSuDung)) {
            return redirect()->back()->with('thongbao', 'Căn cước công dân đã tồn tại!');
        }

        $nhanVien->fill([
            'chuc_vu_id' => $request->input('chucvu'),
            'tai_khoan_id' => $request->input('taikhoan'),
            'cua_hang_id' => $request->input('cuahang'),
            'kho_id' => $request->input('kho'),
            'ho_ten' => $request->input('hoten'),
            'dia_chi' => $request->input('diachi'),
            'ngay_sinh' => $request->input('ngaysinh'),
            'gioi_tinh' => $request->input('gioitinh'),
            'so_dien_thoai' => $request->input('sdt'),
            'cccd' => $request->input('cccd'),
            'bhxh' => $request->input('bhxh'),
        ]);
        if ($nhanVien->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật nhân viên thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật nhân viên không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function destroy(NhanVien $nhanVien)
    {
        //
    }

    public function indexNhanVien($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if (empty($taiKhoan)) {
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachNhanVien = DB::select('select a.*, b.ho_ten as ten_quan_ly, cua_hangs.ten_cua_hang, khos.ten_kho, chuc_vus.ten_chuc_vu
            from nhan_viens a, nhan_viens b, chuc_vus, cua_hangs, khos
            where a.quan_ly_id = b.id and a.chuc_vu_id = chuc_vus.id and a.cua_hang_id = cua_hangs.id and a.kho_id = khos.id');
            foreach ($danhSachNhanVien as $tp) {
                $tp->ngay_sinh = Carbon::createFromFormat('Y-m-d', $tp->ngay_sinh)->format('d/m/Y');
            }
            $danhSachHSL = HeSoLuong::all();
            $danhSachThuong = Thuong::all();
            $danhSachPhuCap = PhuCap::all();
            return view('admin/management-page/staff', [
                'danhSachNhanVien' => $danhSachNhanVien, 'danhSachHSL' => $danhSachHSL,
                'danhSachThuong' => $danhSachThuong, 'danhSachPhuCap' => $danhSachPhuCap
            ]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 2) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            $danhSachNhanVien = DB::select('select a.*, b.ho_ten as ten_quan_ly, cua_hangs.ten_cua_hang, khos.ten_kho, chuc_vus.ten_chuc_vu
            from nhan_viens a, nhan_viens b, chuc_vus, cua_hangs, khos
            where a.quan_ly_id = b.id and a.chuc_vu_id = chuc_vus.id and a.cua_hang_id = cua_hangs.id and a.kho_id = khos.id
            and a.cua_hang_id = ? and a.id != ?', [$quanLy->cua_hang_id, $quanLy->id]);
            foreach ($danhSachNhanVien as $tp) {
                $tp->ngay_sinh = Carbon::createFromFormat('Y-m-d', $tp->ngay_sinh)->format('d/m/Y');
            }
            $danhSachHSL = HeSoLuong::all();
            $danhSachThuong = Thuong::all();
            $danhSachPhuCap = PhuCap::all();
            return view('admin/management-page/staff', [
                'danhSachNhanVien' => $danhSachNhanVien, 'danhSachHSL' => $danhSachHSL,
                'danhSachThuong' => $danhSachThuong, 'danhSachPhuCap' => $danhSachPhuCap
            ]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 3) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->first();
            $danhSachNhanVien = DB::select('select a.*, b.ho_ten as ten_quan_ly, cua_hangs.ten_cua_hang, khos.ten_kho, chuc_vus.ten_chuc_vu
            from nhan_viens a, nhan_viens b, chuc_vus, cua_hangs, khos
            where a.quan_ly_id = b.id and a.chuc_vu_id = chuc_vus.id and a.cua_hang_id = cua_hangs.id and a.kho_id = khos.id
            and a.kho_id = ? and a.id != ?', [$quanLy->kho_id, $quanLy->id]);
            foreach ($danhSachNhanVien as $tp) {
                $tp->ngay_sinh = Carbon::createFromFormat('Y-m-d', $tp->ngay_sinh)->format('d/m/Y');
            }
            $danhSachHSL = HeSoLuong::all();
            $danhSachThuong = Thuong::all();
            $danhSachPhuCap = PhuCap::all();
            return view('admin/management-page/staff', [
                'danhSachNhanVien' => $danhSachNhanVien, 'danhSachHSL' => $danhSachHSL,
                'danhSachThuong' => $danhSachThuong, 'danhSachPhuCap' => $danhSachPhuCap
            ]);
        }
    }

    public function createNhanVien($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if (empty($taiKhoan)) {
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::all();
            $danhSachChucVu = ChucVu::all();
            $danhSachCuaHang = CuaHang::all();
            $danhSachKho = Kho::all();
            $danhSachTaiKhoan = TaiKhoan::where('loai_tai_khoan_id', '!=', 1)
                ->where('loai_tai_khoan_id', '<', 5)
                ->get();
            return view('admin/add-page/add-staff', [
                'danhSachChucVu' => $danhSachChucVu,
                'danhSachCuaHang' => $danhSachCuaHang, 'danhSachKho' => $danhSachKho, 'danhSachTaiKhoan' => $danhSachTaiKhoan,
                'danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan,
            ]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 2) {
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id', '=', 3)->get();
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->get();
            $danhSachChucVu = ChucVu::where('id', '=', 3)->first();
            $danhSachCuaHang = CuaHang::where('id', '=', $quanLy->cua_hang_id)->get();
            $danhSachKho = Kho::where('id', '=', 1)->get();
            $danhSachTaiKhoan = TaiKhoan::where('loai_tai_khoan_id', '=', 4)->get();
            return view('admin/add-page/add-staff', [
                'danhSachChucVu' => $danhSachChucVu,
                'danhSachCuaHang' => $danhSachCuaHang, 'danhSachKho' => $danhSachKho, 'danhSachTaiKhoan' => $danhSachTaiKhoan,
                'danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan,
            ]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 3) {
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id', '=', 3)->get();
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->get();
            $danhSachChucVu = ChucVu::where('id', '=', 3)->first();
            $danhSachCuaHang = CuaHang::where('id', '=', 1)->get();
            $danhSachKho = Kho::where('id', '=', $quanLy->kho_id)->get();
            $danhSachTaiKhoan = TaiKhoan::where('loai_tai_khoan_id', '=', 4)->get();
            return view('admin/add-page/add-staff', [
                'danhSachChucVu' => $danhSachChucVu,
                'danhSachCuaHang' => $danhSachCuaHang, 'danhSachKho' => $danhSachKho, 'danhSachTaiKhoan' => $danhSachTaiKhoan,
                'danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan,
            ]);
        }
    }

    public function editNhanVien($token, $nhanVienId)
    {
        $nhanVien = NhanVien::where('id', '=', $nhanVienId)->first();
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if (empty($taiKhoan)) {
            return redirect()->intended('/admin');
        }

        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::all();
            $danhSachChucVu = ChucVu::all();
            $danhSachCuaHang = CuaHang::all();
            $danhSachKho = Kho::all();
            $danhSachTaiKhoan = TaiKhoan::where('loai_tai_khoan_id', '!=', 1)
                ->where('loai_tai_khoan_id', '<', 5)
                ->get();
            return view('admin/edit-page/edit-staff', [
                'danhSachChucVu' => $danhSachChucVu,
                'danhSachCuaHang' => $danhSachCuaHang, 'danhSachKho' => $danhSachKho, 'danhSachTaiKhoan' => $danhSachTaiKhoan,
                'nhanVien' => $nhanVien, 'danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan,
            ]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 2) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->get();
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id', '=', 3)->get();
            $danhSachChucVu = ChucVu::where('id', '=', 3)->first();
            $danhSachCuaHang = CuaHang::where('id', '=', $quanLy->cua_hang_id)->get();
            $danhSachKho = Kho::where('id', '=', 1)->get();
            $danhSachTaiKhoan = TaiKhoan::where('loai_tai_khoan_id', '=', 4)->get();
            return view('admin/edit-page/edit-staff', [
                'danhSachChucVu' => $danhSachChucVu,
                'danhSachCuaHang' => $danhSachCuaHang, 'danhSachKho' => $danhSachKho, 'danhSachTaiKhoan' => $danhSachTaiKhoan,
                'nhanVien' => $nhanVien, 'danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan,
            ]);
        }
        if ($taiKhoan->loai_tai_khoan_id == 3) {
            $quanLy = NhanVien::where('tai_khoan_id', '=', $taiKhoan->id)->get();
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id', '=', 3)->get();
            $danhSachChucVu = ChucVu::where('id', '=', 3)->first();
            $danhSachCuaHang = CuaHang::where('id', '=', 1)->get();
            $danhSachKho = Kho::where('id', '=', $quanLy->kho_id)->get();
            $danhSachTaiKhoan = TaiKhoan::where('loai_tai_khoan_id', '=', 4)->get();
            return view('admin/edit-page/edit-staff', [
                'danhSachChucVu' => $danhSachChucVu,
                'danhSachCuaHang' => $danhSachCuaHang, 'danhSachKho' => $danhSachKho, 'danhSachTaiKhoan' => $danhSachTaiKhoan,
                'nhanVien' => $nhanVien, 'danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan,
            ]);
        }
    }


    public function destroyNhanVien($nhanVienId)
    {
        $nhanVien = NhanVien::where('id', '=', $nhanVienId)->first();
        if ($nhanVien->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa nhân viên thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa nhân viên không thành công !');
    }
}
