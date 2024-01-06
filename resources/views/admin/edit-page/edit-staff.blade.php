@extends('admin.layouts.app-admin')
@section('content')
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Thêm nhân viên</h4>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a
                                href="{{ route('indexNhanVien', ['token' => Auth::user()->token]) }}">
                                <button type="button" class="btn btn-outline-primary">
                                    <i class="fa fa-list-ul"></i> Quản lý nhân viên
                                </button>
                            </a>
                            <hr>
                            <form action="{{ route('nhanVien.update', ['nhanVien' => $nhanVien]) }}" method="post"
                                accept-charset="utf-8">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="token"
                                    value='{{Auth::user()->token}}'>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="card-title">THÔNG TIN NHÂN VIÊN</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Họ tên<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="hoten" type="text"
                                                            style="height: 40px;" placeholder="Họ tên"
                                                            value="{{ $nhanVien->ho_ten }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Địa chỉ<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="diachi" type="text"
                                                            style="height: 40px;" placeholder="Địa chỉ"
                                                            value="{{ $nhanVien->dia_chi }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Ngày sinh<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="ngaysinh" type="date"
                                                            style="height: 40px;" placeholder="Ngày sinh"
                                                            value="{{ $nhanVien->ngay_sinh }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Giới tính<span style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-12" style="z-index: 1">
                                                        <select name="gioitinh"
                                                            class="select2 form-select shadow-none select2-hidden-accessible"
                                                            style="width: 100%; height:36px;" tabindex="-1"
                                                            aria-hidden="true">
                                                            @if ($nhanVien->gioi_tinh == 1)
                                                                <option value="0">Nữ</option>
                                                                <option value="1" selected>Nam</option>
                                                            @else
                                                                <option value="0" selected>Nữ</option>
                                                                <option value="1">Nam</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">SĐT<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="sdt" type="text"
                                                            style="height: 40px;" placeholder="SĐT"
                                                            value="{{ $nhanVien->so_dien_thoai }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">CCCD<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="cccd" type="text"
                                                            style="height: 40px;" placeholder="CCCD"
                                                            value="{{ $nhanVien->cccd }}" required max="12">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">BHXH<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="bhxh" type="text"
                                                            style="height: 40px;" placeholder="BHXH"
                                                            value="{{ $nhanVien->bhxh }}" required max="10">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Chức vụ<span style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-11" style="z-index: 1">
                                                        <select name="chucvu"
                                                            class="select2 form-select shadow-none select2-hidden-accessible"
                                                            style="width: 100%; height:36px;" tabindex="-1"
                                                            aria-hidden="true">
                                                            @foreach ($danhSachChucVu as $tp)
                                                                <option value="{{ $tp->id }}">{{ $tp->ten_chuc_vu }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary add-chucvu"
                                                        style="width: 40px;">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Cửa hàng<span style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-11" style="z-index: 1">
                                                        <select name="cuahang"
                                                            class="select2 form-select shadow-none select2-hidden-accessible"
                                                            style="width: 100%; height:36px;" tabindex="-1"
                                                            aria-hidden="true">
                                                            @foreach ($danhSachCuaHang as $tp)
                                                                @if ($nhanVien->cua_hang_id == $tp->id)
                                                                    <option value="{{ $tp->id }}" selected>
                                                                        {{ $tp->ten_cua_hang }}</option>
                                                                @else
                                                                    <option value="{{ $tp->id }}">
                                                                        {{ $tp->ten_cua_hang }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary add-cuahang"
                                                        style="width: 40px;">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Kho<span style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-11" style="z-index: 1">
                                                        <select name="kho"
                                                            class="select2 form-select shadow-none select2-hidden-accessible"
                                                            style="width: 100%; height:36px;" tabindex="-1"
                                                            aria-hidden="true">
                                                            @foreach ($danhSachKho as $tp)
                                                                @if ($nhanVien->kho_id == $tp->id)
                                                                    <option value="{{ $tp->id }}" selected>
                                                                        {{ $tp->ten_kho }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $tp->id }}">
                                                                        {{ $tp->ten_kho }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary add-kho"
                                                        style="width: 40px;">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Tài khoản<span style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-11" style="z-index: 1">
                                                        <select name="taikhoan"
                                                            class="select2 form-select shadow-none select2-hidden-accessible"
                                                            style="width: 100%; height:36px;" tabindex="-1"
                                                            aria-hidden="true">
                                                            @foreach ($danhSachTaiKhoan as $tp)
                                                                @if ($nhanVien->tai_khoan_id == $tp->id)
                                                                    <option value="{{ $tp->id }}" selected>
                                                                        {{ $tp->username }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $tp->id }}">
                                                                        {{ $tp->username }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary add-taikhoan"
                                                        style="width: 40px;">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center; margin-top: 20px">
                                        <button type="submit" class="btn btn-primary">Cập nhật nhân viên</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- Form thêm chức vụ --}}
                        <div class="popup themchucvu">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm chức vụ</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('chucVu.store') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tên chức vụ<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tenchucvu" type="text"
                                                                style="height: 40px;" placeholder="Tên chức vụ" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12">Lương cơ bản<span
                                                                style="color:red">*</span></label>
                                                        <div>
                                                            <input class="form-control" name="luongcoban" type="number"
                                                                style="height: 40px; width: 95%; float: left;"
                                                                id="product_price" placeholder="0" value="" min="0"
                                                                required>
                                                            <div
                                                                style="background-color: #ebebeb;padding: 8.5px;text-align: center;border-radius: 3px;border: 1px solid #ccc;">
                                                                đ</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12"
                                            style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm chức vụ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm cửa hàng --}}
                        <div class="popup themcuahang">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm cửa hàng</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('cuaHang.store') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tên cửa hàng<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tencuahang" type="text"
                                                                style="height: 40px;" placeholder="Tên cửa hàng" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Địa chỉ<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="diachi" type="text"
                                                                style="height: 40px;" placeholder="Địa chỉ" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12"
                                            style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm cửa hàng</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm kho --}}
                        <div class="popup themkho">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm kho</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('kho.store') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tên kho<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tenkho" type="text"
                                                                style="height: 40px;" placeholder="Tên kho" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Địa chỉ<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="diachi" type="text"
                                                                style="height: 40px;" placeholder="Địa chỉ" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12"
                                            style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm kho</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm tài khoản --}}
                        <div class="popup themtaikhoan">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm tài khoản</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('taiKhoan.store') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <input type="hidden" name="token" value='{{Auth::user()->token}}'>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Username<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="username" type="text"
                                                                style="height: 40px;" placeholder="Username" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12">Loại tài khoản<span style="color:red">*</span>
                                                        </label>
                                                        <div class="col-sm-12" style="z-index: 1">
                                                            <select name="loaitaikhoan"
                                                                class="select2 form-select shadow-none select2-hidden-accessible"
                                                                style="width: 100%; height:36px;" tabindex="-1"
                                                                aria-hidden="true">
                                                                @foreach ($danhSachLoaiTaiKhoan as $tp)
                                                                    <option value="{{ $tp->id }}">{{ $tp->ten_loai_tai_khoan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Mật khẩu<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-11" style="width: 450px">
                                                            <input class="form-control" name="matkhau" type="password"
                                                                style="height: 40px;" id="matkhau" placeholder="Mật khẩu" value="">
                                                        </div>
                                                        <button type="button" class="btn btn-outline-secondary matkhau"
                                                            style="width: 40px;" onclick="togglepass('matkhau')">
                                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="product_name" class="col-sm-12">Xác nhận mật khẩu<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-11" style="width: 450px">
                                                            <input class="form-control" name="matkhauxacnhan" type="password"
                                                                style="height: 40px;" id="matkhauxacnhan" placeholder="Xác nhận mật khẩu" value="">
                                                        </div>
                                                        <button type="button" class="btn btn-outline-secondary matkhauxacnhan"
                                                            style="width: 40px;" onclick="togglepass('matkhauxacnhan')">
                                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12"
                                            style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        @if (Session::has('thongbao'))
                            <div class="popup active ketqua">
                                <div class="bg-popup"></div>
                                <div class="form-popup" style="width: auto">
                                    <div class="row-popup" style="text-align: center;">
                                        <h3 style="color:gray">Thông báo</h3>
                                    </div>
                                    <h4 style="display:block;text-align: center;">{{ Session::get('thongbao') }}</h4>
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="closepopup()">Ok</button>
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Thông báo validate --}}
                        @if ($errors->any())
                            <div class="popup active ketqua">
                                <div class="bg-popup"></div>
                                <div class="form-popup" style="width: auto">
                                    <div class="row-popup" style="text-align: center;">
                                        <h3 style="color:gray">Thông báo</h3>
                                    </div>
                                    @foreach ($errors->all() as $error)
                                        <h4 style="display:block;text-align: center;">{{ $error }}</h4>
                                    @endforeach
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="closepopup()">Ok</button>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        {{-- <footer class="footer text-center">
            All Rights Reserved by Matrix-admin. Designed and Developed by <a
                href="https://www.wrappixel.com">WrapPixel</a>.
        </footer> --}}
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->

    <script type="text/javascript">
        const body = this.document.querySelector('body');
        //Lấy thành phần form
        const btnthemchucvu = this.document.querySelector('.add-chucvu');
        const popupthemchucvu = this.document.querySelector('.popup.themchucvu');
        const btnclosethemchucvu = this.document.querySelector('.popup.themchucvu .form-popup .row-popup button');

        const btnthemcuahang = this.document.querySelector('.add-cuahang');
        const popupthemcuahang = this.document.querySelector('.popup.themcuahang');
        const btnclosethemcuahang = this.document.querySelector('.popup.themcuahang .form-popup .row-popup button');

        const btnthemkho = this.document.querySelector('.add-kho');
        const popupthemkho = this.document.querySelector('.popup.themkho');
        const btnclosethemkho = this.document.querySelector('.popup.themkho .form-popup .row-popup button');

        const btnthemtaikhoan = this.document.querySelector('.add-taikhoan');
        const popupthemtaikhoan = this.document.querySelector('.popup.themtaikhoan');
        const btnclosethemtaikhoan = this.document.querySelector('.popup.themtaikhoan .form-popup .row-popup button');

        //Hiển thị form thêm
        btnthemchucvu.onclick = function() {
            popupthemchucvu.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemcuahang.onclick = function() {
            popupthemcuahang.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemkho.onclick = function() {
            popupthemkho.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemtaikhoan.onclick = function() {
            popupthemtaikhoan.className += " active";
            body.style = "overflow: hidden;";
        };


        //Đóng form thêm
        btnclosethemchucvu.onclick = function() {
            popupthemchucvu.className = popupthemchucvu.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemcuahang.onclick = function() {
            popupthemcuahang.className = popupthemcuahang.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemkho.onclick = function() {
            popupthemkho.className = popupthemkho.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemtaikhoan.onclick = function() {
            popupthemtaikhoan.className = popupthemtaikhoan.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }
    </script>
@endsection
