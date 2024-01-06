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
                    <h4 class="page-title">Quản lý hình ảnh 360</h4>
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
                            <a href="{{ route('dienThoai.edit', ['dienThoai' => $dienThoai]) }}"><button type="button"
                                    class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> QUAY LẠI
                                </button><a>
                                    <button type="button" class="btn btn-outline-primary add-360picture">
                                        <i class="fas fa-plus-circle"></i> THÊM HÌNH ẢNH 360
                                    </button>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th class='thNormal'>Hình ảnh</th>
                                                    <th class='thNormal' style='width:100px'>Chức năng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($danhSachHinhAnh360 as $tp)
                                                    <tr>
                                                        <td><?php echo ++$i; ?></td>
                                                        <td><p style="width: fit-content; border-style: outset;"><img src="{{ asset('storage/images/' . $tp->hinh_anh) }}"
                                                                style="width: 250px"></p></td>
                                                        <td>
                                                            {{-- https://jsfiddle.net/prasun_sultania/KSk42/ hướng dẫn chỉnh lại title --}}
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="hienthiformcapnhat('{{ route('hinhAnhChungCuaDienThoai.update', ['hinhAnhChungCuaDienThoai' => $tp]) }}','{{ asset('storage/images/' . $tp->hinh_anh) }}')"
                                                                title="Chỉnh sửa thông tin hình ảnh 360"><i
                                                                    class="far fa-edit"></i></button>
                                                            <button type="button" class="btn btn-outline-danger"
                                                                onclick="confirm('{{ route('hinhAnhChungCuaDienThoai.destroy', ['hinhAnhChungCuaDienThoai' => $tp]) }}')"
                                                                title="Xóa hình ảnh 360"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Hình ảnh</th>
                                                    <th class='thNormal' style='width:100px'>Chức năng</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                        </div>
                        {{-- Form thêm ảnh 360 --}}
                        <div class="popup themhinh360">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong>Thêm hình ảnh 360</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('themHinhAnh360') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <input type="hidden" name="dienthoaiid" value='{{ $dienThoai->id }}'>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6" style="margin-left: 26.5%;">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label>Hình ảnh nổi bật</label>
                                                                    <div class="col-sm-11 image-profile" align="center">
                                                                        <img class="profile-pic hinhanh360"
                                                                            src="{{ asset('assets/admin/images/icon-logo.png') }}"
                                                                            name="filed">
                                                                        <div class="upload-herf cursor" id="hinhanh360"
                                                                            onclick="uploadpic(this.id)">
                                                                            Tải ảnh lên</div>
                                                                        <input class="file-upload hinhanh360"
                                                                            name="hinhanh360" type="file"
                                                                            accept="image/x-png,image/gif,image/jpeg"
                                                                            id="store_logo"
                                                                            data-msg-accept="Chỉ nhận tập tin jpg|jpeg|png|gif">
                                                                        <input hidden="hidden" name="old_logo" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:20px">
                                            <button type="submit" class="btn btn-primary">Thêm hình ảnh</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form cập nhật ảnh 360 --}}
                        <div class="popup capnhathinh360">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong>Cập nhật hình ảnh nổi bật</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="#" enctype="multipart/form-data" method="post" accept-charset="utf-8"
                                    id="formupdate">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="dienthoaiid" value='{{ $dienThoai->id }}'>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6" style="margin-left: 26.5%;">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label>Hình ảnh 360</label>
                                                                    <div class="col-sm-11 image-profile" align="center">
                                                                        <img class="profile-pic hinhanh" src="#"
                                                                            name="filed" id="anh360">
                                                                        <div class="upload-herf cursor" id="hinhanh"
                                                                            onclick="uploadpic(this.id)">
                                                                            Tải ảnh lên</div>
                                                                        <input class="file-upload hinhanh" name="hinhanh"
                                                                            type="file"
                                                                            accept="image/x-png,image/gif,image/jpeg"
                                                                            id="store_logo"
                                                                            data-msg-accept="Chỉ nhận tập tin jpg|jpeg|png|gif">
                                                                        <input hidden="hidden" name="old_logo" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:20px">
                                            <button type="submit" class="btn btn-primary">Cập nhật hình ảnh</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form xác nhân xóa --}}
                        <div class="popup xacnhanxoa">
                            <div class="bg-popup"></div>
                            <div class="form-popup" style="width: auto">
                                <div class="row-popup">
                                    <h3 style="color:red;text-align: center;">Xóa hình ảnh 360</h3>
                                </div>
                                <form method="post" action="#" id="formdelete">
                                    @csrf
                                    @method('DELETE')
                                    <h4 style="display:block">Bạn có muốn xóa hình ảnh 360 này không
                                        ?</h4>
                                    <p style="margin-top: 10px; text-align: center">
                                        <button type="submit" class="btn btn-outline-danger">Có</button>
                                        <button type="button" class="btn btn-outline-secondary formclose">Không</button>
                                    </p>

                                </form>
                            </div>
                        </div>

                        {{-- Thông báo kết quả --}}
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
        var readURL = function(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.profile-pic.' + id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        function uploadpic(id) {
            $(".file-upload." + id).click();
            $(".file-upload." + id).on('change', function() {
                readURL(this, id);
            });
        }
        $('.bootstrap-tagsinput input').keydown(function(event) {
            if (event.which == 13) {
                $(this).blur();
                $(this).focus();
                return false;
            }
        })
    </script>
    <script>
        const body = this.document.querySelector('body');
        //Lấy thành phần form thêm
        const btnthemhinh = this.document.querySelector('.add-360picture');
        const popupthemhinh = this.document.querySelector('.popup.themhinh360');
        const btnclosethemhinh = this.document.querySelector('.popup.themhinh360 .form-popup .row-popup button');
        //Hiển thị form thêm
        btnthemhinh.onclick = function() {
            popupthemhinh.className += " active";
            body.style = "overflow: hidden;";
        };

        //Đóng form thêm
        btnclosethemhinh.onclick = function() {
            popupthemhinh.className = popupthemhinh.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        //Lấy thành phần form cập nhật
        const popupcapnhathinh = this.document.querySelector('.popup.capnhathinh360');
        const btnclosecapnhathinh = this.document.querySelector('.popup.capnhathinh360 .form-popup .row-popup button');
        //Hiển thị form cập nhật
        function hienthiformcapnhat($url, $image) {
            popupcapnhathinh.className += " active";
            body.style = "overflow: hidden;";
            $('#formupdate').attr('action', $url);
            document.getElementById("anh360").src = $image;
        };

        //Đóng form cập nhật
        btnclosecapnhathinh.onclick = function() {
            popupcapnhathinh.className = popupcapnhathinh.className.replace(" active", "");
            body.style = "overflow: auto;";
        };


        const popupxacnhanxoa = this.document.querySelector('.popup.xacnhanxoa');
        const btncloseformxoa = this.document.querySelector('.formclose');
        //Hiển thị
        function confirm($url) {
            popupxacnhanxoa.className += " active";
            body.style = "overflow: hidden;";
            $('#formdelete').attr('action', $url);
        };
        //Đóng
        btncloseformxoa.onclick = function() {
            popupxacnhanxoa.className = popupxacnhanxoa.className.replace(" active", "");
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
