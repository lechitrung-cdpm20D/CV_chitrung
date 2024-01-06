@extends('admin.layouts.app-admin')
@section('content')
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Quản lý khách hàng</h4>
                    {{-- <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                            </ol>
                        </nav>
                    </div> --}}
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
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Username</th>
                                            <th>Tên khách hàng</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Sđt</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th>Bậc thành viên</th>
                                            <th>Loại tài khoản</th>
                                            <th>Trạng thái</th>
                                            <th class='thNormal' style='width:100px'>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($danhSachKhachHang as $tp)
                                            <tr>
                                                <td><?php echo ++$i; ?></td>
                                                <td>{{ $tp->username }}</td>
                                                <td>{{ $tp->ho_ten }}</td>
                                                <td>{{ $tp->ngay_sinh }}</td>
                                                <td>
                                                    @if ($tp->gioi_tinh == 1)
                                                        Nam
                                                    @else
                                                        Nữ
                                                    @endif
                                                </td>
                                                <td>{{ $tp->so_dien_thoai }}</td>
                                                <td>
                                                    <p>{{ $tp->dia_chi }}</p>
                                                </td>
                                                <td>{{ $tp->email }}</td>
                                                <td>{{ $tp->ten_bac_tai_khoan }}</td>
                                                <td>{{ $tp->ten_loai_tai_khoan }}</td>
                                                <td>
                                                    @if ($tp->trang_thai == 1)
                                                        Hoạt động
                                                    @else
                                                        Khóa
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-dark"
                                                        onclick="confirmthaydoitrangthai('{{ route('thayDoiTrangThaiTaiKhoan', ['taiKhoanId' => $tp->id]) }}')"
                                                        title="Thay đổi trạng thái khách hàng">
                                                        @if ($tp->trang_thai == 0)
                                                            <i class="fas fa-eye"></i>
                                                        @else
                                                            <i class="fas fa-eye-slash"></i>
                                                        @endif
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        onclick="confirm('{{ route('taiKhoan.destroy', ['taiKhoan' => $tp]) }}')"
                                                        title="Xóa khách hàng"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Username</th>
                                            <th>Tên khách hàng</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Sđt</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th>Bậc thành viên</th>
                                            <th>Loại tài khoản</th>
                                            <th>Trạng thái</th>
                                            <th class='thNormal' style='width:100px'>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="popup">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="width: auto">
                                <div class="row-popup">
                                    <h3 style="color:red;text-align: center;">Xóa khách hàng</h3>
                                </div>
                                <form method="post" action="#" id="formdelete">
                                    @csrf
                                    @method('DELETE')
                                    <h4 style="display:block">Bạn có muốn xóa khách hàng này không ?</h4>
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="submit" class="btn btn-outline-danger">Có</button>
                                        <button type="button" class="btn btn-outline-secondary formclose">Không</button>
                                    </p>

                                </form>
                            </div>
                        </div>

                        {{-- Xác nhận thay đổi trạng thái --}}
                        <div class="popup thaydoitrangthai">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="width: auto">
                                <div class="row-popup">
                                    <h3 style="color:red;text-align: center;">Thay đổi trạng thái khách hàng</h3>
                                </div>
                                <form method="post" action="#" id="formthaydoitrangthai">
                                    @csrf
                                    <h4 style="display:block">Bạn có muốn thay đổi trạng thái khách hàng này không
                                        ?</h4>
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="submit" class="btn btn-outline-danger">Có</button>
                                        <button type="button"
                                            class="btn btn-outline-secondary formclose thaydoitrangthai">Không</button>
                                    </p>

                                </form>
                            </div>
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
        const popup = this.document.querySelector('.popup');
        const body = this.document.querySelector('body');
        const btnclose = this.document.querySelector('.formclose');
        //Hiển thị
        function confirm($url) {
            popup.className += " active";
            body.style = "overflow: hidden;";
            $('#formdelete').attr('action', $url);
        };
        //Đóng
        btnclose.onclick = function() {
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        //Đóng thông báo kết quả
        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }

        const popupthaydoitrangthai = this.document.querySelector('.popup.thaydoitrangthai');
        const btnclosethaydoitrangthai = this.document.querySelector('.formclose.thaydoitrangthai');
        //Hiển thị
        function confirmthaydoitrangthai($url) {
            popupthaydoitrangthai.className += " active";
            body.style = "overflow: hidden;";
            $('#formthaydoitrangthai').attr('action', $url);
        };
        //Đóng
        btnclosethaydoitrangthai.onclick = function() {
            popupthaydoitrangthai.className = popupthaydoitrangthai.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
    </script>
@endsection
