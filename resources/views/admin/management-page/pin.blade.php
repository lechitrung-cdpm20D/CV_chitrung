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
                    <h4 class="page-title">Quản lý pin sạc</h4>
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
                            <a href="{{ route('pin_Sac.create') }}"><button type="button" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i> THÊM PIN SẠC
                                </button><a>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Dung lượng pin</th>
                                                    <th>Loại pin</th>
                                                    <th>Hỗ trợ sạc tối đa</th>
                                                    <th>Sạc kèm theo máy</th>
                                                    <th>Công nghệ pin</th>
                                                    <th class='thNormal' style='width:100px'>Chức năng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($danhSachPinSac as $tp)
                                                    <tr>
                                                        <td><?php echo ++$i; ?></td>
                                                        <td>{{ $tp->dung_luong_pin }}</td>
                                                        <td>{{ $tp->loai_pin }}</td>
                                                        <td>{{ $tp->ho_tro_sac_toi_da }}</td>
                                                        <td>{{ $tp->sac_kem_theo_may }}</td>
                                                        <td>{{ $tp->cong_nghe_pin }}</td>
                                                        <td>
                                                            {{-- https://jsfiddle.net/prasun_sultania/KSk42/ hướng dẫn chỉnh lại title --}}
                                                            <a href="{{ route('pin_Sac.edit', ['pin_Sac' => $tp]) }}"><button
                                                                    type="button" class="btn btn-outline-secondary"
                                                                    title="Chỉnh sửa thông tin pin sạc"><i
                                                                        class="far fa-edit"></i></button></a>
                                                            <button type="button" class="btn btn-outline-danger"
                                                                onclick="confirm('{{ route('pin_Sac.destroy', ['pin_Sac' => $tp]) }}')"
                                                                title="Xóa pin sạc"><i class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Dung lượng pin</th>
                                                    <th>Loại pin</th>
                                                    <th>Hỗ trợ sạc tối đa</th>
                                                    <th>Sạc kèm theo máy</th>
                                                    <th>Công nghệ pin</th>
                                                    <th>Chức năng</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                        </div>
                        <div class="popup">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="width: auto">
                                <div class="row-popup">
                                    <h3 style="color:red;text-align: center;">Xóa pin - sạc</h3>
                                </div>
                                <form method="post" action="#" id="formdelete">
                                    @csrf
                                    @method('DELETE')
                                    <h4 style="display:block">Bạn có muốn xóa pin - sạc này không
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
    </script>
@endsection
