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
                    <h4 class="page-title">Quản lý nhân viên</h4>
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
                            <a href="{{ route('createNhanVien', ['token' => Auth::user()->token]) }}"><button
                                    type="button" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i> THÊM NHÂN VIÊN
                                </button><a>
                                    <a href="{{ route('indexQuanLyLuong', ['token' => Auth::user()->token]) }}"><button
                                            type="button" class="btn btn-outline-secondary">
                                            <i class="fa fa-list-ul"></i> QUẢN LÝ LƯƠNG
                                        </button><a>
                                            <hr>
                                            <div class="table-responsive">
                                                <table id="zero_config" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Họ tên nhân viên</th>
                                                            <th>Địa chỉ</th>
                                                            <th>Ngày sinh</th>
                                                            <th>Giới tính</th>
                                                            <th>SĐT</th>
                                                            <th>CCCD</th>
                                                            <th>BHXH</th>
                                                            <th>Chức vụ</th>
                                                            <th>Quản lý</th>
                                                            <th>Cửa hàng</th>
                                                            <th>Kho</th>
                                                            <th class='thNormal' style='width:100px'>Chức năng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($danhSachNhanVien as $tp)
                                                            <tr>
                                                                <td><?php echo ++$i; ?></td>
                                                                <td>{{ $tp->ho_ten }}</td>
                                                                <td>
                                                                    <p>{{ $tp->dia_chi }}</p>
                                                                </td>
                                                                <td>{{ $tp->ngay_sinh }}</td>
                                                                <td>
                                                                    @if ($tp->gioi_tinh == 1)
                                                                        Nam
                                                                    @else
                                                                        Nữ
                                                                    @endif
                                                                </td>
                                                                <td>{{ $tp->so_dien_thoai }}</td>
                                                                <td>{{ $tp->cccd }}</td>
                                                                <td>{{ $tp->bhxh }}</td>
                                                                <td>{{ $tp->ten_chuc_vu }}</td>
                                                                <td>{{ $tp->ten_quan_ly }}</td>
                                                                <td>{{ $tp->ten_cua_hang }}</td>
                                                                <td>{{ $tp->ten_kho }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-outline-primary"
                                                                        onclick="chamcong('{{ route('chamCongNhanVien', ['nhanVienId' => $tp->id]) }}')"
                                                                        title="Chấm công"><i
                                                                            class="fas fa-money-bill-alt"></i></button>
                                                                    <a
                                                                        href="{{ route('editNhanVien', [
                                                                            'token' => Auth::user()->token,
                                                                            'nhanVienId' => $tp->id,
                                                                        ]) }}">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            title="Chỉnh sửa thông tin nhân viên"><i
                                                                                class="far fa-edit"></i></button>
                                                                    </a>
                                                                    <button type="button" class="btn btn-outline-danger"
                                                                        onclick="confirm('{{ route('destroyNhanVien', ['nhanVienId' => $tp->id]) }}')"
                                                                        title="Xóa nhân viên"><i
                                                                            class="fas fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Họ tên</th>
                                                            <th>Địa chỉ</th>
                                                            <th>Ngày sinh</th>
                                                            <th>Giới tính</th>
                                                            <th>SĐT</th>
                                                            <th>CCCD</th>
                                                            <th>BHXH</th>
                                                            <th>Chức vụ</th>
                                                            <th>Quản lý</th>
                                                            <th>Cửa hàng</th>
                                                            <th>Kho</th>
                                                            <th>Chức năng</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                        </div>
                        {{-- Chấm công --}}
                        <div class="popup chamcong">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="height: 75%;">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Chấm công</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="#" method="get" accept-charset="utf-8" id="formchamcong">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12">Hệ số lương<span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-12" style="z-index: 1">
                                                <select name="hesoluong"
                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                    style="width: 100%; height:36px;" tabindex="-1" aria-hidden="true">
                                                    @foreach ($danhSachHSL as $tp)
                                                        <option value="{{ $tp->ma_hsl }}">{{ $tp->ma_hsl }} -
                                                            {{ $tp->he_so_luong }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12">Thưởng<span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-12" style="z-index: 1">
                                                <select name="thuong"
                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                    style="width: 100%; height:36px;" tabindex="-1" aria-hidden="true">
                                                    @foreach ($danhSachThuong as $tp)
                                                        <option value="{{ $tp->ma_thuong }}">{{ $tp->ma_thuong }} -
                                                            {{ $tp->tien_thuong }} VNĐ
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12">Phụ cấp<span style="color:red">*</span>
                                            </label>
                                            <div class="col-sm-12" style="z-index: 1">
                                                <select name="phucap"
                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                    style="width: 100%; height:36px;" tabindex="-1" aria-hidden="true">
                                                    @foreach ($danhSachPhuCap as $tp)
                                                        <option value="{{ $tp->ma_phu_cap }}">{{ $tp->ma_phu_cap }} -
                                                            {{ $tp->tien_phu_cap }} VNĐ
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-12">Ứng trước<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name="ungtruoc" type="number"
                                                    style="height: 40px;" placeholder="Ứng trước" value="" min='0' required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-12">Số ngày làm việc<span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-12">
                                                <input class="form-control" name="songaylamviec" type="number"
                                                    style="height: 40px;" placeholder="Số ngày làm việc" value="" min='0'
                                                    max='26' step="1" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px">
                                            <button type="submit" class="btn btn-primary" style="width:50%">Chấm
                                                công</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="popup xacnhanxoa">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="width: auto">
                                <div class="row-popup">
                                    <h3 style="color:red;text-align: center;">Xóa nhân viên</h3>
                                </div>
                                <form method="get" action="#" id="formdelete">
                                    <h4 style="display:block">Bạn có muốn xóa nhân viên này không
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
