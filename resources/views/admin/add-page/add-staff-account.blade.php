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
                    <h4 class="page-title">Thêm tài khoản nhân viên</h4>
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
                                href="{{ route('indexTaiKhoanNhanVien', ['token' => Auth::user()->token]) }}">
                                <button type="button" class="btn btn-outline-primary">
                                    <i class="fa fa-list-ul"></i> Quản lý tài khoản nhân viên
                                </button>
                            </a>
                            <hr>
                            <form action="{{ route('taiKhoan.store') }}" method="post" accept-charset="utf-8">
                                @csrf
                                <input type="hidden" name="token" value='{{ Auth::user()->token }}'>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="card-title">TÀI KHOẢN NHÂN VIÊN MỚI</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Username<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="username" type="text"
                                                            style="height: 40px;" placeholder="Username" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Loại tài khoản<span style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-11" style="z-index: 1">
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
                                                    <button type="button" class="btn btn-outline-secondary add-loaitaikhoan"
                                                        style="width: 40px;">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Mật khẩu<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-11">
                                                        <input class="form-control" name="matkhau" type="password"
                                                            style="height: 40px;" id="matkhau" placeholder="Mật khẩu" value="">
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary matkhau"
                                                        style="width: 40px;" onclick="togglepass('matkhau')">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="product_name" class="col-sm-12">Xác nhận mật khẩu<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-11">
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
                                    <div class="col-md-12" style="text-align: center; margin-top: 20px">
                                        <button type="submit" class="btn btn-primary">Thêm tài khoản nhân viên</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- Form thêm loại tài khoản --}}
                        <div class="popup themloaitaikhoan">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm loại tài khoản</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('loaiTaiKhoan.store') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tên loại tài khoản<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tenloaitaikhoan" type="text"
                                                                style="height: 40px;" placeholder="Tên loại tài khoản" value=""
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
                                            <button type="submit" class="btn btn-primary">Thêm loại tài khoản</button>
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
        const btnthemloaitaikhoan = this.document.querySelector('.add-loaitaikhoan');
        const popupthemloaitaikhoan = this.document.querySelector('.popup.themloaitaikhoan');
        const btnclosethemloaitaikhoan = this.document.querySelector('.popup.themloaitaikhoan .form-popup .row-popup button');

        //Hiển thị form thêm
        btnthemloaitaikhoan.onclick = function() {
            popupthemloaitaikhoan.className += " active";
            body.style = "overflow: hidden;";
        };

        //Đóng form thêm
        btnclosethemloaitaikhoan.onclick = function() {
            popupthemloaitaikhoan.className = popupthemloaitaikhoan.className.replace(" active", "");
            body.style = "overflow: auto;";
        }

        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }

        function togglepass($variable) {
            var x = document.getElementById($variable);
            var i = document.querySelector('.'+$variable+' i');
            if (x.type === "password") {
                x.type = "text";
                i.className = i.className.replace("fas fa-eye", "fas fa-eye-slash");
            } else {
                x.type = "password";
                i.className = i.className.replace("fas fa-eye-slash", "fas fa-eye");
            }
        }
    </script>
@endsection
