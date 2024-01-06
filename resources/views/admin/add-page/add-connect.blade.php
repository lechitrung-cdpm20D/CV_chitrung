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
                    <h4 class="page-title">Thêm kết nối</h4>
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
                            <a href="{{ route('ketNoi.index') }}">
                                <button type="button" class="btn btn-outline-primary">
                                    <i class="fa fa-list-ul"></i> Quản lý kết nối
                                </button>
                            </a>
                            <hr>
                            <form action="{{ route('ketNoi.store') }}" method="post" accept-charset="utf-8">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="card-title">KẾT NỐI MỚI</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Mạng di động<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="mangdidong" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Mạng di động" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Sim<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="sim" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Sim" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Wifi<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="wifi" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Wifi" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Gps<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="gps" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Gps" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Bluetooth<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="bluetooth" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Bluetooth" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Cổng kết nối<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="congketnoi" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Cổng kết nối" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Jack tai nghe<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="jacktainghe" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Jack tai nghe" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12">Kết nối khác<span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="ketnoikhac" type="text"
                                                            style="height: 40px;"
                                                            placeholder="Kết nối khác" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center; margin-top:20px">
                                        <button type="submit" class="btn btn-primary">Thêm kết nối</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (Session::has('thongbao'))
                            <div class="popup active ketqua">
                                <div class="bg-popup"></div>
                                <div class="form-popup" style="width: auto">
                                    <div class="row-popup" style="text-align: center;">
                                        <h3 style="color:gray">Thông báo</h3>
                                    </div>
                                    <h4 style="display:block;text-align: center;">{{ Session::get('thongbao') }}</h4>
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="button" class="btn btn-outline-secondary" onclick="closepopup()">Ok</button>
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
    <script>
        const body = this.document.querySelector('body');
        //Đóng thông báo kết quả
        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }
    </script>
@endsection
