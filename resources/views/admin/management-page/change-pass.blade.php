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
                    <h4 class="page-title">Đổi mật khẩu</h4>
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
                            <form action="/change-pass" method="post" accept-charset="utf-8">
                                @csrf
                                <div style="position: relative;left: 30%;">
                                    <div class="col-sm-12">
                                        <h4 class="card-title">Form đổi mật khẩu</h4>
                                        <div>
                                            <div class="col-sm-5">
                                                <div class="form-group row">
                                                    <label for="product_name" class="col-sm-12">Mật khẩu cũ<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-11">
                                                        <input type="hidden" name='username'
                                                            value="{{ Auth::user()->username }}">
                                                        <input class="form-control" name="matkhaucu" type="password"
                                                            style="height: 40px;" id="matkhaucu" placeholder="Mật khẩu cũ"
                                                            value="">
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary matkhaucu"
                                                        style="width: 40px;" onclick="togglepass('matkhaucu')">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group row">
                                                    <label for="product_name" class="col-sm-12">Mật khẩu mới<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-11">
                                                        <input class="form-control" name="matkhaumoi" type="password"
                                                            style="height: 40px;" id="matkhaumoi" placeholder="Mật khẩu mới"
                                                            value="">
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary matkhaumoi"
                                                        style="width: 40px;" onclick="togglepass('matkhaumoi')">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group row">
                                                    <label for="product_name" class="col-sm-12">Xác nhận mật khẩu
                                                        mới<span style="color:red">*</span></label>
                                                    <div class="col-sm-11">
                                                        <input class="form-control" name="matkhauxacnhan" type="password"
                                                            style="height: 40px;" id="matkhauxacnhan"
                                                            placeholder="Xác nhận mật khẩu mới" value="">
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
                                    <div class="col-md-12" style="text-align: center; margin-top:20px">
                                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                                    </div>
                                </div>
                            </form>
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
    <script>
        const body = this.document.querySelector('body');
        //Đóng thông báo kết quả
        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }

        function togglepass($variable) {
            var x = document.getElementById($variable);
            var i = document.querySelector('.' + $variable + ' i');
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
