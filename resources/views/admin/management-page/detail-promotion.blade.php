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
                    <h4 class="page-title">Quản lý khuyến mãi</h4>
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
                            <a href="{{ route('khuyenMai.index') }}"><button type="button"
                                    class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> QUAY LẠI
                                </button><a>
                                    <button type="button" class="btn btn-outline-primary add-detail">
                                        <i class="fas fa-plus-circle"></i> THÊM CHI TIẾT KHUYẾN MÃI
                                    </button>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thương hiệu</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Phần trăm giảm</th>
                                                    <th class='thNormal' style='width:100px'>Chức năng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($danhSachChiTietKhuyenMai as $tp)
                                                    <tr>
                                                        <td><?php echo ++$i; ?></td>
                                                        <td>{{ $tp->ten_thuong_hieu }}</td>
                                                        <td>{{ $tp->ten_san_pham }}</td>
                                                        <td>{{ $tp->phan_tram_giam }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="edit('{{ route('chiTietKhuyenMai.update', ['chiTietKhuyenMai' => $tp]) }}',{{ $tp->phan_tram_giam }})"
                                                                title="Chỉnh sửa thông tin chi tiết khuyến mãi"><i
                                                                    class="far fa-edit"></i></button>
                                                            <button type="button" class="btn btn-outline-danger"
                                                                onclick="confirm('{{ route('chiTietKhuyenMai.destroy', ['chiTietKhuyenMai' => $tp]) }}')"
                                                                title="Xóa chi tiết khuyến mãi"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thương hiệu</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Phần trăm giảm</th>
                                                    <th>Chức năng</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                        </div>

                        {{-- Thêm chi tiết sản phẩm --}}
                        <div class="popup themchitiet">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="height: 80%;overflow-y: scroll;max-width: none">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm chi tiết khuyến mãi mới</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('chiTietKhuyenMai.store') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <input type='hidden' name="khuyenmaiid" value="{{ $khuyenMai->id }}">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-12">Phần trăm giảm (Theo số thập phân VD: 0.1 =
                                                10%)<span style="color:red">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name="phantramgiam"
                                                    style="height: 40px;" placeholder="Phần trăm giảm" value="" required pattern="[0-9]+([,\.][0-9]+)?">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-popup" style="padding: 0"><strong style="font-size: 16px">Chọn sản
                                            phẩm muốn khuyến mãi</strong></div>
                                    <div class="table-responsive">
                                        <table id="one_config" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thương hiệu</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th class='thNormal' style='pointer-events: all'>Lựa chọn <input
                                                            type="checkbox" id="checkAll"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($danhSachSanPham as $tp)
                                                    <tr>
                                                        <td><?php echo ++$i; ?></td>
                                                        <td>{{ $tp->ten_thuong_hieu }}</td>
                                                        <td>{{ $tp->ten_san_pham }}</td>
                                                        <td>
                                                            <input type="checkbox" name="sanpham[]"
                                                                value="{{ $tp->id }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thương hiệu</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Lựa chọn</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:20px">
                                            <button type="submit" class="btn btn-primary" style="width:40%">Thêm chi tiết
                                                khuyến mãi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Cập nhật chi tiết sản phẩm --}}
                        <div class="popup chinhsua">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="height: 30%;">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Cập nhật chi tiết khuyến mãi</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="#" method="post"
                                    accept-charset="utf-8" id="formupdate">
                                    @csrf
                                    @method('PATCH')
                                    <input type='hidden' name="khuyenmaiid" value="{{ $khuyenMai->id }}">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-12">Phần trăm giảm (Theo số thập phân VD: 0.1 =
                                                10%)<span style="color:red">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name="phantramgiam" id="phantramgiam"
                                                    style="height: 40px;" placeholder="Phần trăm giảm" value="" required pattern="[0-9]+([,\.][0-9]+)?">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px">
                                            <button type="submit" class="btn btn-primary" style="width:50%">Cập nhật chi
                                                tiết
                                                khuyến mãi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Xác nhận xóa --}}
                        <div class="popup xacnhanxoa">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="width: auto">
                                <div class="row-popup">
                                    <h3 style="color:red;text-align: center;">Xóa chi tiết khuyến mãi</h3>
                                </div>
                                <form method="post" action="#" id="formdelete">
                                    @csrf
                                    @method('DELETE')
                                    <h4 style="display:block">Bạn có muốn xóa chi tiết khuyến mãi này không
                                        ?</h4>
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="submit" class="btn btn-outline-danger">Có</button>
                                        <button type="button" class="btn btn-outline-secondary formclose">Không</button>
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

        //Chỉnh sửa thông tin
        const popupchinhsua = this.document.querySelector('.popup.chinhsua');
        const btnclosechinhsua = this.document.querySelector('.popup.chinhsua .form-popup .row-popup button');
        //Hiển thị
        function edit($url,$phantramgiam) {
            popupchinhsua.className += " active";
            body.style = "overflow: hidden;";
            $('#formupdate').attr('action', $url);
            document.getElementById('phantramgiam').value = $phantramgiam;
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

        //Lấy thành phần form thêm chi tiết
        const btnthemchitiet = this.document.querySelector('.add-detail');
        const popupthemchitiet = this.document.querySelector('.popup.themchitiet');
        const btnclosethemchitiet = this.document.querySelector('.popup.themchitiet .form-popup .row-popup button');
        //Hiển thị form thêm chi tiết
        btnthemchitiet.onclick = function() {
            popupthemchitiet.className += " active";
            body.style = "overflow: hidden;";
        };

        //Đóng form thêm chi tiết
        btnclosethemchitiet.onclick = function() {
            popupthemchitiet.className = popupthemchitiet.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        //Chọn tất cả
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
