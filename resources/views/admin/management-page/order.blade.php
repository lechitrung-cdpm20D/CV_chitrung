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
                    <h4 class="page-title">Quản lý đơn hàng</h4>
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
                            {{-- <a href="#"><button type="button" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i>
                                </button><a>
                                    <hr> --}}
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Họ tên người nhận</th>
                                            <th>Số điện thoại người nhận</th>
                                            <th>Địa chỉ nhận hàng</th>
                                            <th>Phiếu giảm giá</th>
                                            <th>Ghi chú</th>
                                            <th>Phương thức nhận hàng</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái thanh toán</th>
                                            <th>Trạng thái đơn hàng</th>
                                            <th>Ngày tạo đơn</th>
                                            <th>Ngày giao hàng</th>
                                            <th class='thNormal' style='width:100px'>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($danhSachDonHang as $tp)
                                            <tr>
                                                <td><?php echo ++$i; ?></td>
                                                <td>{{ $tp->ma_don_hang }}</td>
                                                <td>{{ $tp->ho_ten_nguoi_nhan }}</td>
                                                <td>{{ $tp->so_dien_thoai_nguoi_nhan }}</td>
                                                <td>
                                                    <p>{{ $tp->dia_chi_nhan_hang }}</p>
                                                </td>
                                                <td>
                                                    @if ($tp->phieu_giam_gia_id != null)
                                                        Có áp dụng
                                                    @else
                                                        Không áp dụng
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tp->ghi_chu == null)
                                                        Không có
                                                    @else
                                                        <p>{{ $tp->ghi_chu }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tp->phuong_thuc_nhan_hang == 1)
                                                        Giao tận nhà
                                                    @else
                                                        Nhận tại cửa hàng
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tp->phuong_thuc_thanh_toan == 1)
                                                        Thanh toán tiền mặt khi nhận hàng
                                                    @elseif($tp->phuong_thuc_thanh_toan == 2)
                                                        Thanh toán qua PayPal
                                                    @elseif($tp->phuong_thuc_thanh_toan == 3)
                                                        Thanh toán qua VNPay
                                                    @elseif($tp->phuong_thuc_thanh_toan == 4)
                                                        Thanh toán qua MoMo
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tp->trang_thai_thanh_toan == 0)
                                                        Chưa thanh toán
                                                    @else
                                                        Đã thanh toán
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tp->trang_thai_don_hang == 0)
                                                        Đang xử lý
                                                    @elseif($tp->trang_thai_don_hang == 1)
                                                        Đã xử lý
                                                    @elseif($tp->trang_thai_don_hang == 2)
                                                        Đang vận chuyển
                                                    @elseif($tp->trang_thai_don_hang == 3)
                                                        Đã nhận hàng
                                                    @elseif($tp->trang_thai_don_hang == 4)
                                                        Đã hủy
                                                    @endif
                                                </td>
                                                <td>{{ $tp->ngay_tao }}</td>
                                                <td>
                                                    @if ($tp->ngay_giao == null)
                                                        Chưa có thông tin
                                                    @else
                                                        {{ $tp->ngay_giao }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="edit('{{ route('capNhatTrangThaiDH', ['maDonHang' => $tp->ma_don_hang]) }}',{{ $tp->trang_thai_don_hang }})"
                                                        title="Cập nhật trạng thái đơn hàng"><i
                                                            class="far fa-edit"></i></button>
                                                    <a
                                                        href="{{ route('showDonHang', ['maDonHang' => $tp->ma_don_hang]) }}"><button
                                                            type="button" class="btn btn-outline-info"
                                                            title="Xem chi tiết đơn hàng"><i
                                                                class="fas fa-info"></i></button></a>
                                                    <a target="_blank"
                                                        href="{{ route('createBill', ['maDonHang' => $tp->ma_don_hang]) }}"><button
                                                            type="button" class="btn btn-outline-dark"
                                                            title="In hóa đơn"><i class="fas fa-print"></i></button></a>
                                                    {{-- @else
                                                        <button type="button" class="btn btn-outline-dark disabled"
                                                            title="In hóa đơn"><i class="fas fa-print"></i></button>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Họ tên người nhận</th>
                                            <th>Số điện thoại người nhận</th>
                                            <th>Địa chỉ nhận hàng</th>
                                            <th>Phiếu giảm giá</th>
                                            <th>Ghi chú</th>
                                            <th>Phương thức nhận hàng</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái thanh toán</th>
                                            <th>Trạng thái đơn hàng</th>
                                            <th>Ngày tạo đơn</th>
                                            <th>Ngày giao hàng</th>
                                            <th class='thNormal' style='width:100px'>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        {{-- Cập nhật trạng thái --}}
                        <div class="popup chinhsua">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="height: 30%;">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Cập nhật trạng thái đơn hàng</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="#" method="post" accept-charset="utf-8" id="formupdate">
                                    @csrf
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-12">Trạng thái đơn hàng<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-12">
                                                <select name="trangthaidonhang" id="trangthaidonhang"
                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                    style="width: 100%; height:36px;" tabindex="-1" aria-hidden="true">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px">
                                            <button type="submit" class="btn btn-primary" style="width:50%">Cập nhật trạng
                                                thái</button>
                                        </div>
                                    </div>
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
        //Chỉnh sửa thông tin
        const popupchinhsua = this.document.querySelector('.popup.chinhsua');
        const btnclosechinhsua = this.document.querySelector('.popup.chinhsua .form-popup .row-popup button');
        const body = this.document.querySelector('body');

        function removeOptions(selectElement) {
            var i, L = selectElement.options.length - 1;
            for (i = L; i >= 0; i--) {
                selectElement.remove(i);
            }
        }
        //Hiển thị
        function edit($url, $trangthaidonhang) {
            popupchinhsua.className += " active";
            body.style = "overflow: hidden;";
            select = document.getElementById('trangthaidonhang');
            $('#formupdate').attr('action', $url);
            removeOptions(select);
            if ($trangthaidonhang == 0) {
                var opt = document.createElement('option');
                opt.value = 0;
                opt.innerHTML = 'Đang xử lý';
                select.appendChild(opt);
                var opt = document.createElement('option');
                opt.value = 1;
                opt.innerHTML = 'Đã xử lý';
                select.appendChild(opt);
            } else if ($trangthaidonhang == 1) {
                var opt = document.createElement('option');
                opt.value = 1;
                opt.innerHTML = 'Đã xử lý';
                select.appendChild(opt);
                var opt = document.createElement('option');
                opt.value = 2;
                opt.innerHTML = 'Đang vận chuyển';
                select.appendChild(opt);
            } else if ($trangthaidonhang == 2) {
                var opt = document.createElement('option');
                opt.value = 2;
                opt.innerHTML = 'Đang vận chuyển';
                select.appendChild(opt);
                var opt = document.createElement('option');
                opt.value = 3;
                opt.innerHTML = 'Đã nhận hàng';
                select.appendChild(opt);
                var opt = document.createElement('option');
                opt.value = 4;
                opt.innerHTML = 'Đã hủy';
                select.appendChild(opt);
            } else if ($trangthaidonhang == 3) {
                var opt = document.createElement('option');
                opt.value = 3;
                opt.innerHTML = 'Đã nhận hàng';
                select.appendChild(opt);
            } else {
                var opt = document.createElement('option');
                opt.value = 4;
                opt.innerHTML = 'Đã hủy';
                select.appendChild(opt);
            }
        };

        //Đóng
        btnclosechinhsua.onclick = function() {
            popupchinhsua.className = popupchinhsua.className.replace(" active", "");
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
