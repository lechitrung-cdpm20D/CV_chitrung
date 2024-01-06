<?php

namespace App\Http\Controllers;

use App\Models\LoaiTaiKhoan;
use App\Models\TaiKhoan;
use App\Models\ThongTinTaiKhoan;
use App\Mail\RecoverPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class TaiKhoanController extends Controller
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
     * @param  \App\Http\Requests\StoreTaiKhoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $request->input('token'))->first();
        if (empty($taiKhoan)) {
            return redirect()->back()->with('thongbao', 'Thêm không thành công ! Token đã bị chỉnh sửa !');
        }
        if ($taiKhoan->loai_tai_khoan_id != 1 && $request->input('loaitaikhoan') == 1 || $request->input('loaitaikhoan') == 2 || $request->input('loaitaikhoan') == 3) {
            return redirect()->back()->with('thongbao', 'Tài khoản này không có quyền thêm loại tài khoản này !');
        }
        // Kiểm tra id loại tài khoản
        $danhSach = LoaiTaiKhoan::all();
        $chuoiId = '';
        $dem = 0;
        foreach ($danhSach as $tp) {
            if ($dem == 0) {
                $chuoiId = $tp->id;
            } else {
                $chuoiId = $chuoiId . ',' . $tp->id;
            }
            $dem++;
        }

        //Kiểm tra các trường input
        $validated = Validator::make(
            $request->all(),
            [
                'username' => 'required|min:6|max:20|regex:/^\S*$/u',
                'loaitaikhoan' => 'required|in:' . $chuoiId,
                'matkhau' => 'required|min:6|max:20',
                'matkhauxacnhan' => 'required|same:matkhau',
            ],
            $messages = [
                'required' => ':attribute là bắt buộc !',
                'min' => ':attribute tối thiểu 6 ký tự !',
                'max' => ':attribute tối đa 20 ký tự !',
                'same' => ':attribute không khớp với mật khẩu !',
                'regex' => ':attribute không hợp lệ !',
            ],
            [
                'username' => 'Username',
                'loaitaikhoan' => 'Loại tài khoản',
                'matkhau' => 'Mật khẩu',
                'matkhauxacnhan' => 'Mật khẩu xác nhận',
            ]
        )->validate();

        $ktUsername = TaiKhoan::where('username', '=', $request->input('username'))->first();
        if (empty($ktUsername)) {
            $taiKhoan = new TaiKhoan();
            $taiKhoan->fill([
                'loai_tai_khoan_id' => $request->input('loaitaikhoan'),
                'bac_tai_khoan_id' => 1,
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('matkhau')),
                'diem_thuong' => 0,
                'token' => Str::random(60),
                'trang_thai' => 1,
            ]);
            if ($taiKhoan->save() == true) {
                return redirect()->back()->with('thongbao', 'Thêm tài khoản nhân viên thành công !');
            }
            return redirect()->back()->with('thongbao', 'Thêm tài khoản nhân viên không thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm tài khoản nhân viên không thành công ! Username đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function show(TaiKhoan $taiKhoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function edit(TaiKhoan $taiKhoan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaiKhoanRequest  $request
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaiKhoan $taiKhoan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaiKhoan $taiKhoan)
    {
        if ($taiKhoan->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa không thành công !');
    }

    public function indexKhachHang()
    {
        $danhSachKhachHang = TaiKhoan::join('thong_tin_tai_khoans', 'thong_tin_tai_khoans.tai_khoan_id', '=', 'tai_khoans.id')
            ->join('bac_tai_khoans', 'bac_tai_khoans.id', '=', 'tai_khoans.bac_tai_khoan_id')
            ->join('loai_tai_khoans', 'loai_tai_khoans.id', '=', 'tai_khoans.loai_tai_khoan_id')
            ->where('loai_tai_khoan_id', '>', 4)
            ->select('tai_khoans.*', 'bac_tai_khoans.ten_bac_tai_khoan', 'loai_tai_khoans.ten_loai_tai_khoan', 'thong_tin_tai_khoans.ho_ten', 'thong_tin_tai_khoans.dia_chi', 'thong_tin_tai_khoans.so_dien_thoai', 'thong_tin_tai_khoans.email', 'thong_tin_tai_khoans.ngay_sinh', 'thong_tin_tai_khoans.gioi_tinh')
            ->get();
        foreach ($danhSachKhachHang as $tp) {
            $tp->ngay_sinh = Carbon::createFromFormat('Y-m-d', $tp->ngay_sinh)->format('d/m/Y');
        }
        return view('admin/management-page/customer', ['danhSachKhachHang' => $danhSachKhachHang]);
    }

    public function thayDoiTrangThaiTaiKhoan($taiKhoanId)
    {
        $taiKhoan = TaiKhoan::where('id', '=', $taiKhoanId)->first();
        if ($taiKhoan->trang_thai == 0) {
            if ($taiKhoan->update(['trang_thai' => 1]) == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật trạng thái thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái không thành công !');
        } else {
            if ($taiKhoan->update(['trang_thai' => 0]) == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật trạng thái thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái không thành công !');
        }
    }

    public function indexTaiKhoanNhanVien($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if (empty($taiKhoan)) {
            return redirect()->intended('/admin');
        }
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachTaiKhoan = TaiKhoan::join('thong_tin_tai_khoans', 'thong_tin_tai_khoans.tai_khoan_id', '=', 'tai_khoans.id')
                ->join('bac_tai_khoans', 'bac_tai_khoans.id', '=', 'tai_khoans.bac_tai_khoan_id')
                ->join('loai_tai_khoans', 'loai_tai_khoans.id', '=', 'tai_khoans.loai_tai_khoan_id')
                ->where('tai_khoans.id', '!=', $taiKhoan->id)
                ->where('loai_tai_khoans.id', '<', 5)
                ->select('tai_khoans.*', 'bac_tai_khoans.ten_bac_tai_khoan', 'loai_tai_khoans.ten_loai_tai_khoan', 'thong_tin_tai_khoans.ho_ten')
                ->get();
            return view('admin/management-page/staff-account', ['danhSachTaiKhoan' => $danhSachTaiKhoan]);
        } else {
            if ($taiKhoan->loai_tai_khoan_id == 2) {
                $taiKhoan = TaiKhoan::join('nhan_viens', 'nhan_viens.tai_khoan_id', '=', 'tai_khoans.id')
                    ->where('tai_khoans.id', '=', $taiKhoan->id)
                    ->select('tai_khoans.*', 'nhan_viens.cua_hang_id')
                    ->first();
                $danhSachTaiKhoan = TaiKhoan::join('thong_tin_tai_khoans', 'thong_tin_tai_khoans.tai_khoan_id', '=', 'tai_khoans.id')
                    ->join('nhan_viens', 'nhan_viens.tai_khoan_id', '=', 'tai_khoans.id')
                    ->join('bac_tai_khoans', 'bac_tai_khoans.id', '=', 'tai_khoans.bac_tai_khoan_id')
                    ->join('loai_tai_khoans', 'loai_tai_khoans.id', '=', 'tai_khoans.loai_tai_khoan_id')
                    ->where('tai_khoans.id', '!=', $taiKhoan->id)
                    ->where('loai_tai_khoans.id', '<', 5)
                    ->where('nhan_viens.cua_hang_id', '=', $taiKhoan->cua_hang_id)
                    ->select('tai_khoans.*', 'bac_tai_khoans.ten_bac_tai_khoan', 'loai_tai_khoans.ten_loai_tai_khoan', 'thong_tin_tai_khoans.ho_ten')
                    ->get();
                return view('admin/management-page/staff-account', ['danhSachTaiKhoan' => $danhSachTaiKhoan]);
            } else {
                $taiKhoan = TaiKhoan::join('nhan_viens', 'nhan_viens.tai_khoan_id', '=', 'tai_khoans.id')
                    ->where('tai_khoans.id', '=', $taiKhoan->id)
                    ->select('tai_khoans.*', 'nhan_viens.kho_id')
                    ->first();
                $danhSachTaiKhoan = TaiKhoan::join('thong_tin_tai_khoans', 'thong_tin_tai_khoans.tai_khoan_id', '=', 'tai_khoans.id')
                    ->join('nhan_viens', 'nhan_viens.tai_khoan_id', '=', 'tai_khoans.id')
                    ->join('bac_tai_khoans', 'bac_tai_khoans.id', '=', 'tai_khoans.bac_tai_khoan_id')
                    ->join('loai_tai_khoans', 'loai_tai_khoans.id', '=', 'tai_khoans.loai_tai_khoan_id')
                    ->where('tai_khoans.id', '!=', $taiKhoan->id)
                    ->where('loai_tai_khoans.id', '<', 5)
                    ->where('nhan_viens.kho_id', '=', $taiKhoan->kho_id)
                    ->select('tai_khoans.*', 'bac_tai_khoans.ten_bac_tai_khoan', 'loai_tai_khoans.ten_loai_tai_khoan', 'thong_tin_tai_khoans.ho_ten')
                    ->get();
                return view('admin/management-page/staff-account', ['danhSachTaiKhoan' => $danhSachTaiKhoan]);
            }
        }
    }

    public function changepassword(Request $request)
    {
        //Kiểm tra các trường input
        $validated = Validator::make(
            $request->all(),
            [
                'matkhaucu' => 'required|min:6|max:20',
                'matkhaumoi' => 'required|min:6|max:20|different:matkhaucu',
                'matkhauxacnhan' => 'required|same:matkhaumoi',
            ],
            $messages = [
                'required' => ':attribute là bắt buộc !',
                'min' => ':attribute tối thiểu là 6 ký tự !',
                'same' => ':attribute không khớp với mật khẩu mới !',
                'different' => ':attribute không được giống với mật khẩu cũ !',
                'max' => ':attribute tối đa 20 ký tự !',
            ],
            [
                'matkhaucu' => 'Mật khẩu cũ',
                'matkhaumoi' => 'Mật khẩu mới',
                'matkhauxacnhan' => 'Mật khẩu xác nhận',
            ]
        )->validate();

        if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('matkhaucu')])) {
            $user = TaiKhoan::where('username', '=', $request->input('username'))->first();
            $user->fill([
                'password' => bcrypt($request->input('matkhaumoi')),
            ]);
            if ($user->save() == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật mật khẩu thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật mật khẩu không thành công ! Có lỗi đã xảy ra !');
        }
        return redirect()->back()->with('thongbao', 'Mật khẩu cũ không chính xác!');
    }

    public function createTaiKhoanNhanVien($token)
    {
        $taiKhoan = TaiKhoan::where('token', '=', $token)->first();
        if ($taiKhoan->loai_tai_khoan_id == 1) {
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id', '!=', 1)->get();
            return view('admin/add-page/add-staff-account', ['danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan]);
        } else {
            $danhSachLoaiTaiKhoan = LoaiTaiKhoan::where('id', '=', 4)->get();
            return view('admin/add-page/add-staff-account', ['danhSachLoaiTaiKhoan' => $danhSachLoaiTaiKhoan]);
        }
    }

    public function authenticate(Request $request)
    {
        $taiKhoan = TaiKhoan::where('username', '=', $request->input('username'))->first();
        if (!empty($taiKhoan)) {
            if ($taiKhoan->trang_thai == 1) {
                if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password'), 'trang_thai' => 1])) {
                    $taiKhoan = TaiKhoan::where('username', '=', $request->input('username'))->first();
                    $request->session()->regenerate();
                    if ($taiKhoan->loai_tai_khoan_id < 5) {
                        return redirect()->intended('/admin');
                    } else {
                        return redirect()->intended('/');
                    }
                }
                return back()->withErrors([
                    'error' => 'Tên đăng nhập hoặc mật khẩu không chính xác !',
                ]);
            } else {
                return back()->withErrors([
                    'error' => 'Tài khoản đã bị khóa !',
                ]);
            }
        }
        return back()->withErrors([
            'error' => 'Tên đăng nhập hoặc mật khẩu không chính xác !',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/signin');
    }

    public function storeTaiKhoanKhachHang(Request $request)
    {
        //Kiểm tra các trường input
        $validated = Validator::make(
            $request->all(),
            [
                'username' => 'required|min:6|max:20|regex:/^\S*$/u',
                'hoten' => 'required',
                'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'matkhau' => 'required|min:6|max:20',
                'matkhauxacnhan' => 'required|same:matkhau',
            ],
            $messages = [
                'required' => ':attribute là bắt buộc !',
                'min' => ':attribute tối thiểu 6 ký tự !',
                'max' => ':attribute tối đa 20 ký tự !',
                'same' => ':attribute không khớp với mật khẩu !',
                'regex' => ':attribute không hợp lệ !',
            ],
            [
                'username' => 'Username',
                'hoten' => 'Họ tên',
                'email' => 'Email',
                'matkhau' => 'Mật khẩu',
                'matkhauxacnhan' => 'Mật khẩu xác nhận',
            ]
        )->validate();

        $ktUsername = TaiKhoan::where('username', '=', $request->input('username'))->first();
        $ktEmail = ThongTinTaiKhoan::where('email', '=', $request->input('email'))->first();
        if (empty($ktUsername)) {
            if (empty($ktEmail)) {
                $taiKhoan = new TaiKhoan();
                $taiKhoan->fill([
                    'loai_tai_khoan_id' => 5,
                    'bac_tai_khoan_id' => 1,
                    'username' => $request->input('username'),
                    'password' => bcrypt($request->input('matkhau')),
                    'diem_thuong' => 0,
                    'token' => Str::random(60),
                    'trang_thai' => 1,
                ]);
                if ($taiKhoan->save() == true) {
                    $thongTinTaiKhoan = new ThongTinTaiKhoan();
                    $thongTinTaiKhoan->fill([
                        'tai_khoan_id' => $taiKhoan->id,
                        'ho_ten' => $request->input('hoten'),
                        'dia_chi' => null,
                        'so_dien_thoai' => null,
                        'email' => $request->input('email'),
                        'ngay_sinh' => Carbon::now('Asia/Ho_Chi_Minh'),
                        'gioi_tinh' => 1,
                    ]);
                    if ($thongTinTaiKhoan->save() == true) {
                        return redirect()->back()->with('thongbao', 'Đăng ký tài khoản thành công !');
                    }
                }
                return redirect()->back()->with('thongbao', 'Đăng ký tài khoản không thành công !');
            }
            return redirect()->back()->with('thongbao', 'Đăng ký tài khoản không thành công ! Email đã được tài khoản khác sử dụng !');
        }
        return redirect()->back()->with('thongbao', 'Đăng ký tài khoản không thành công ! Username đã tồn tại !');
    }

    public function getPassword(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'username' => 'required|min:6|max:20|regex:/^\S*$/u',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'min' => ':attribute tối thiểu 6 ký tự !',
                'max' => ':attribute tối đa 20 ký tự !',
                'regex' => ':attribute không hợp lệ !',
            ],
            [
                'username' => 'Username',
            ]
        )->validate();

        $taiKhoan = TaiKhoan::where('username', '=', $request->input('username'))->first();
        if (!empty($taiKhoan)) {
            if ($taiKhoan->loai_tai_khoan_id == 5) {
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', $taiKhoan->id)->first();
                $details = [
                    'link' => 'http://localhost:8000/recoverpassword?token=' . $taiKhoan->token,
                ];
                Mail::to($thongTinTaiKhoan->email)->send(new RecoverPass($details));
                return redirect()->back()->with(['thongbao' => 'Gửi yêu cầu thành công !']);
            }
            return redirect()->back()->with(['thongbao' => 'Đây không phải là loại tài khoản khách hàng của hệ thống T&T Mobile !']);
        }
        return redirect()->back()->with('thongbao', 'Username không tồn tại !');
    }

    public function recoverPassword(Request $request)
    {
        //Kiểm tra các trường input
        $validated = Validator::make(
            $request->all(),
            [
                'matkhaumoi' => 'required|min:6|max:20',
                'matkhauxacnhan' => 'required|same:matkhaumoi',
            ],
            $messages = [
                'required' => ':attribute là bắt buộc !',
                'min' => ':attribute tối thiểu 6 ký tự !',
                'max' => ':attribute tối đa 20 ký tự !',
                'same' => ':attribute không khớp với mật khẩu mới!',
                'regex' => ':attribute không hợp lệ !',
            ],
            [
                'matkhaumoi' => 'Mật khẩu mới',
                'matkhauxacnhan' => 'Mật khẩu xác nhận',
            ]
        )->validate();

        $taiKhoan = TaiKhoan::where('token', $request->input('token'))->first();
        if (!empty($taiKhoan)) {
            TaiKhoan::where('token', $request->input('token'))->update(['password' => bcrypt($request->input('matkhaumoi')), 'token' => Str::random(60)]);
            return redirect()->route('signin')->with(['thongbao' => 'Cập nhật mật khẩu mới thành công !']);
        }
        return redirect()->back()->with(['thongbao' => 'Link cập nhật mật khẩu đã được sử dụng !', 'token' => $request->input('token')]);
    }

    public function thongTinTaiKhoanKH()
    {
        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
        return view('user/account-information', ['thongTinTaiKhoan' => $thongTinTaiKhoan]);
    }

    public function capNhatThongTin(Request $request)
    {
        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', $request->taiKhoanId)->first();
        if (!empty($thongTinTaiKhoan)) {
            $validated = Validator::make(
                $request->all(),
                [
                    'hoTen' => 'required|max:30',
                    'gioiTinh' => 'required|in:1,0',
                    'sdt' => 'required|regex:/(09)[0-9]{8}/',
                    'diaChi' => 'required|max:300',
                    'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                    'ngaySinh' => 'required|date|before: today',
                ],
                $messages = [
                    'required' => ':attribute không được bỏ trống !',
                    'max' => ':attribute vượt quá số ký tự cho phép !',
                    'regex' => ':attribute không hợp lệ ! Vui lòng kiểm tra lại !',
                    'before' => ':attribute không hợp lệ !',
                ],
                [
                    'hoTen' => 'Họ tên khách hàng',
                    'email' => 'Email',
                    'gioiTinh' => 'Giới tính',
                    'sdt' => 'Số điện thoại',
                    'diaChi' => 'Địa chỉ',
                    'ngaySinh' => 'Ngày sinh',
                ]
            );

            if ($validated->fails()) {
                $errors = $validated->getMessageBag();
                $msg = '';
                foreach ($errors->all() as $tp) {
                    $msg .= $tp . ' ';
                }
                return response()->json(
                    $msg,
                    404,
                    ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                    JSON_UNESCAPED_UNICODE
                );
            }

            $kiemTraEmail = ThongTinTaiKhoan::where('email', '=', $request->email)
                ->where('tai_khoan_id', '!=', $request->taiKhoanId)
                ->first();
            if (empty($kiemTraEmail)) {
                $thongTinTaiKhoan->fill([
                    'ho_ten' => $request->hoTen,
                    'dia_chi' => $request->diaChi,
                    'so_dien_thoai' => $request->sdt,
                    'email' => $request->email,
                    'ngay_sinh' => $request->ngaySinh,
                    'gioi_tinh' => $request->gioiTinh,
                ]);
                $thongTinTaiKhoan->save();
                return response()->json('ok');
            }
            return response()->json(
                'Email này đã được tài khoản khác sử dụng !',
                404,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
        }
        return response()->json(
            'Không tìm thấy tài khoản có id này',
            404,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function thayDoiMatKhau()
    {
        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
        return view('user/change-password', ['thongTinTaiKhoan' => $thongTinTaiKhoan]);
    }

    public function doiMatKhau(Request $request)
    {
        //Kiểm tra các trường input
        $validated = Validator::make(
            $request->all(),
            [
                'matKhauCu' => 'required|min:6|max:20',
                'matKhauMoi' => 'required|min:6|max:20|different:matKhauCu',
                'matKhauXacNhan' => 'required|same:matKhauMoi',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'min' => ':attribute tối thiểu là 6 ký tự !',
                'same' => ':attribute không khớp với mật khẩu mới !',
                'different' => ':attribute không được giống với mật khẩu cũ !',
                'max' => ':attribute tối đa 20 ký tự !',
            ],
            [
                'matKhauCu' => 'Mật khẩu cũ',
                'matKhauMoi' => 'Mật khẩu mới',
                'matKhauXacNhan' => 'Mật khẩu xác nhận',
            ]
        );

        if ($validated->fails()) {
            $errors = $validated->getMessageBag();
            $msg = '';
            foreach ($errors->all() as $tp) {
                $msg .= $tp . ' ';
            }
            return response()->json(
                $msg,
                404,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
        }

        if (Auth::attempt(['username' => Auth::user()->username, 'password' => $request->matKhauCu])) {
            $user = TaiKhoan::where('username', '=',  Auth::user()->username)->first();
            $user->fill([
                'password' => bcrypt($request->matKhauMoi),
            ]);
            $user->save();
            return response()->json('ok');
        }
        return response()->json(
            'Mật khẩu cũ không chính xác !',
            404,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }
}
