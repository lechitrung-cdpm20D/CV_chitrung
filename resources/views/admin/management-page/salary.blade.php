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
                    <h4 class="page-title">Quản lý lương nhân viên</h4>
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
                            <a href="{{ route('indexNhanVien', ['token' => Auth::user()->token]) }}"><button type="button"
                                    class="btn btn-outline-secondary">
                                    <i class="fa fa-list-ul"></i> QUẢN LÝ NHÂN VIÊN
                                </button><a>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Họ tên nhân viên</th>
                                                    <th>CCCD</th>
                                                    <th>Chức vụ</th>
                                                    <th>Hệ số lương</th>
                                                    <th>Thưởng</th>
                                                    <th>Phụ cấp</th>
                                                    <th>Ứng trước</th>
                                                    <th>Ngày làm việc</th>
                                                    <th>Tháng</th>
                                                    <th>Năm</th>
                                                    <th>Lương cơ bản</th>
                                                    <th>Lương gross</th>
                                                    <th>Lương net</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($danhSachLuongNhanVien as $tp)
                                                    <tr>
                                                        <td><?php echo ++$i; ?></td>
                                                        <td>{{ $tp->ho_ten }}</td>
                                                        <td>{{ $tp->cccd }}</td>
                                                        <td>{{ $tp->ten_chuc_vu }}</td>
                                                        <td>{{ $tp->he_so_luong }}</td>
                                                        <td>{{ $tp->tien_thuong }}</td>
                                                        <td>{{ $tp->tien_phu_cap }}</td>
                                                        <td>{{ $tp->ung_truoc }}</td>
                                                        <td>{{ $tp->so_ngay_lam_viec }}</td>
                                                        <td>{{ $tp->thang }}</td>
                                                        <td>{{ $tp->nam }}</td>
                                                        <td>{{ number_format($tp->luong_co_ban,0) }} VNĐ</td>
                                                        <td>
                                                            @if ($tp->so_ngay_lam_viec > 23)
                                                                {{ number_format($tp->luong_co_ban * $tp->he_so_luong +
                                                                $tp->tien_thuong + $tp->tien_phu_cap - $tp->ung_truoc,0)}} VNĐ
                                                            @else
                                                                {{ number_format($tp->luong_co_ban  / 2 *  $tp->he_so_luong  +
                                                                 $tp->tien_thuong  +  $tp->tien_phu_cap  -
                                                                 $tp->ung_truoc,0) }} VNĐ
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($tp->so_ngay_lam_viec > 23)
                                                                {{ number_format(($tp->luong_co_ban  *  $tp->he_so_luong  +
                                                                 $tp->tien_thuong  +  $tp->tien_phu_cap  -
                                                                 $tp->ung_truoc) - 495000, 0)}} VNĐ
                                                            @else
                                                            {{ number_format(($tp->luong_co_ban / 2  *  $tp->he_so_luong  +
                                                                $tp->tien_thuong  +  $tp->tien_phu_cap  -
                                                                $tp->ung_truoc) - 495000, 0)}} VNĐ
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Họ tên nhân viên</th>
                                                    <th>CCCD</th>
                                                    <th>Chức vụ</th>
                                                    <th>Hệ số lương</th>
                                                    <th>Thưởng</th>
                                                    <th>Phụ cấp</th>
                                                    <th>Ứng trước</th>
                                                    <th>Ngày làm việc</th>
                                                    <th>Tháng</th>
                                                    <th>Năm</th>
                                                    <th>Lương cơ bản</th>
                                                    <th>Lương gross</th>
                                                    <th>Lương net</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
        const popupxacnhanxoa = this.document.querySelector('.popup.xacnhanxoa');
        const body = this.document.querySelector('body');
        const btnclose = this.document.querySelector('.formclose');
        //Hiển thị
        function confirm($url) {
            popupxacnhanxoa.className += " active";
            body.style = "overflow: hidden;";
            $('#formdelete').attr('action', $url);
        };
        //Đóng
        btnclose.onclick = function() {
            popupxacnhanxoa.className = popupxacnhanxoa.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        //Chấm công
        const popupchamcong = this.document.querySelector('.popup.chamcong');
        const btnclosechamcong = this.document.querySelector('.popup.chamcong .form-popup .row-popup button');
        //Hiển thị
        function chamcong($url) {
            popupchamcong.className += " active";
            body.style = "overflow: hidden;";
            $('#formchamcong').attr('action', $url);
        };

        //Đóng
        btnclosechamcong.onclick = function() {
            popupchamcong.className = popupchamcong.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        //Đóng thông báo kết quả
        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }
    </script>
@endsection
