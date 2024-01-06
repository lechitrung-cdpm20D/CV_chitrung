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
                    <h4 class="page-title">Thông tin chi tiết sản phẩm</h4>
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
                            <a href="{{ route('dienThoai.index') }}">
                                <button type="button" class="btn btn-outline-primary">
                                    <i class="fa fa-list-ul"></i> Quản lý sản phẩm
                                </button>
                            </a>
                            <a href="{{ route('hinhAnhNoiBat', ['sanPhamId' => $dienThoai->id]) }}">
                                <button type="button" class="btn btn-outline-info">
                                    <i class="fas fa-list-ul"></i> Quản lý hình ảnh nổi bật của sản phẩm
                                </button>
                            </a>
                            <a href="{{ route('hinhAnhMauSac', ['sanPhamId' => $dienThoai->id]) }}">
                                <button type="button" class="btn btn-outline-success">
                                    <i class="fas fa-list-ul"></i> Quản lý hình ảnh màu sắc của sản phẩm
                                </button>
                            </a>
                            <a href="{{ route('hinhAnh360', ['sanPhamId' => $dienThoai->id]) }}">
                                <button type="button" class="btn btn-outline-warning">
                                    <i class="fas fa-list-ul"></i> Quản lý hình ảnh 360 của sản phẩm
                                </button>
                            </a>
                            <button type="button" class="btn btn-outline-secondary add-detail" style="margin-top: 4px">
                                <i class="fas fa-plus-circle"></i> Thêm chi tiết sản phẩm
                            </button>
                            <hr>
                            <form action="{{ route('dienThoai.update', ['dienThoai' => $dienThoai]) }}"
                                enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="card-title">SẢN PHẨM MỚI</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="product_name" class="col-sm-12">Tên sản phẩm <span
                                                            style="color:red">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="tensanpham" type="text"
                                                            style="height: 40px;" id="product_name"
                                                            placeholder="Tên sản phẩm"
                                                            value="{{ $dienThoai->ten_san_pham }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12">Thương hiệu <span
                                                            style="color:red">*</span>
                                                    </label>
                                                    <div class="col-sm-11" style="z-index: 1">
                                                        <select name="thuonghieuid"
                                                            class="select2 form-select shadow-none select2-hidden-accessible"
                                                            style="width: 100%; height:36px;" tabindex="-1"
                                                            aria-hidden="true">
                                                            @foreach ($danhSachThuongHieu as $tp)
                                                                @if ($dienThoai->thuong_hieu_id == $tp->id)
                                                                    <option value="{{ $tp->id }}" selected>
                                                                        {{ $tp->ten_thuong_hieu }}</option>
                                                                @else
                                                                    <option value="{{ $tp->id }}">
                                                                        {{ $tp->ten_thuong_hieu }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary add-brand"
                                                        style="width: 40px;">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="card-title">MÔ TẢ</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>Hình ảnh đại diện</label>
                                                                <div class="col-sm-11 image-profile" align="center">
                                                                    <img class="profile-pic hinhanhdaidien"
                                                                        src="{{ asset('storage/images/' . $hinhAnhDaiDien->hinh_anh) }}"
                                                                        name="filed">
                                                                    <div class="upload-herf cursor" id="hinhanhdaidien"
                                                                        onclick="uploadpic(this.id)">Tải ảnh lên</div>
                                                                    <input class="file-upload hinhanhdaidien"
                                                                        name="hinhanhdaidien" type="file"
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
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>Hình ảnh thông số kỹ thuật</label>
                                                                <div class="col-sm-11 image-profile" align="center">
                                                                    <img class="profile-pic hinhanhthongsokythuat"
                                                                        src="{{ asset('storage/images/' . $hinhAnhThongSoKyThuat->hinh_anh) }}"
                                                                        name="filed">
                                                                    <div class="upload-herf cursor"
                                                                        id="hinhanhthongsokythuat"
                                                                        onclick="uploadpic(this.id)">Tải ảnh lên</div>
                                                                    <input class="file-upload hinhanhthongsokythuat"
                                                                        name="hinhanhthongsokythuat" type="file"
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
                                        <div class="row" style="margin-top:15px">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>Hình ảnh mở hộp</label>
                                                                <div class="col-sm-11 image-profile" align="center">
                                                                    <img class="profile-pic hinhanhmohop"
                                                                        src="{{ asset('storage/images/' . $hinhAnhMoHop->hinh_anh) }}"
                                                                        name="filed">
                                                                    <div class="upload-herf cursor" id="hinhanhmohop"
                                                                        onclick="uploadpic(this.id)">Tải ảnh lên</div>
                                                                    <input class="file-upload hinhanhmohop"
                                                                        name="hinhanhmohop" type="file"
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
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Mô tả</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <textarea class="form-control" tabindex="1" id="description" name="mota" rows="8" placeholder=" Mô tả"
                                                            style="resize: vertical;">{{ $dienThoai->mo_ta }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;margin-top:20px">
                                        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                                    </div>
                                </div>
                            </form>
                            {{-- Thêm thương hiệu --}}
                            <div class="popup">
                                <div class="bg-popup"></div>
                                <div class="form-popup">
                                    <div class="row-popup">
                                        <strong>Thêm thương hiệu</strong>
                                        <button>Đóng</button>
                                    </div>
                                    <form action="{{ route('thuongHieu.store') }}" enctype="multipart/form-data"
                                        method="post" accept-charset="utf-8">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-12">Tên thương hiệu <span
                                                                    style="color:red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" name="tenthuonghieu"
                                                                    type="text" style="height: 40px;" id=""
                                                                    placeholder="Tên thương hiệu" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="card-title">MÔ TẢ</h4>
                                                <div class="row">
                                                    <div class="col-sm-6" style="margin-left: 26.5%;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <label>Hình ảnh đại diện</label>
                                                                        <div class="col-sm-11 image-profile" align="center">
                                                                            <img class="profile-pic hinhanhthuonghieu"
                                                                                src="{{ asset('assets/admin/images/icon-logo.png') }}"
                                                                                name="filed">
                                                                            <div class="upload-herf cursor"
                                                                                id="hinhanhthuonghieu"
                                                                                onclick="uploadpic(this.id)">Tải ảnh lên
                                                                            </div>
                                                                            <input class="file-upload hinhanhthuonghieu"
                                                                                name="hinhanh" type="file"
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
                                                <button type="submit" class="btn btn-primary">Thêm thương hiệu</button>
                                            </div>
                                        </div>
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
                            <hr>
                            <h4 class="card-title">QUẢN LÝ CHI TIẾT SẢN PHẨM</h4>
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên phiên bản</th>
                                            <th>Giá</th>
                                            <th class='thNormal' style='width:100px'>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($danhSachChiTiet as $tp)
                                            <tr>
                                                <td><?php echo ++$i; ?></td>
                                                <td>{{ $tp->ten_san_pham }} -
                                                    {{ $tp->ram }}/{{ $tp->bo_nho_trong }} -
                                                    {{ $tp->ten_mau_sac }}</td>
                                                <td>{{ number_format($tp->gia, 0,',','.') }} VNĐ</td>
                                                <td>
                                                    <a
                                                        href="{{ route('chiTietDienThoai.edit', ['chiTietDienThoai' => $tp]) }}"><button
                                                            type="button" class="btn btn-outline-secondary"
                                                            title="Chỉnh sửa thông tin chi tiết sản phẩm"><i
                                                                class="far fa-edit"></i></button></a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        onclick="confirm('{{ route('chiTietDienThoai.destroy', ['chiTietDienThoai' => $tp]) }}')"
                                                        title="Xóa chi tiết sản phẩm"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên phiên bản</th>
                                            <th>Giá</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- Thêm chi tiết sản phẩm --}}
                            <div class="popup themchitiet">
                                <div class="bg-popup"></div>
                                <div class="form-popup" style="height: 80%;overflow-y: scroll;max-width: none">
                                    <div class="row-popup">
                                        <strong style="font-size: 18px">Thêm chi tiết sản phẩm mới</strong>
                                        <button>Đóng</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center">
                                            <a
                                                href="{{ route('themChiTietSanPham', ['sanPhamId' => $dienThoai->id, 'loaiThem' => 0]) }}"><button
                                                    type="button" class="btn btn-primary" style="width:40%">Thêm chi tiết
                                                    sản phẩm mới</button></a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row-popup" style="padding: 0"><strong style="font-size: 18px">Chọn 1
                                            chi tiết của sản phẩm có sẵn thông số kỹ thuật</strong></div>
                                    <form action="{{ route('themChiTietSanPham') }}"
                                        method="get" accept-charset="utf-8">
                                        <input type='hidden' value="{{ $dienThoai->id }}" name="sanPhamId">
                                        <input type='hidden' value="1" name="loaiThem">
                                        <div class="table-responsive">
                                            <table id="one_config" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên phiên bản</th>
                                                        <th class='thNormal' style='width:100px'>Lựa chọn</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($danhSachChiTiet as $tp)
                                                        <tr>
                                                            <td><?php echo ++$i; ?></td>
                                                            <td>{{ $tp->ten_san_pham }} -
                                                                {{ $tp->ram }}/{{ $tp->bo_nho_trong }} -
                                                                {{ $tp->ten_mau_sac }}</td>
                                                            <td>
                                                                @if ($i == 1)
                                                                    <input type="radio" name="chitietsanpham"
                                                                        value="{{ $tp->id }}" checked="checked">
                                                                @else
                                                                    <input type="radio" name="chitietsanpham"
                                                                        value="{{ $tp->id }}">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên phiên bản</th>
                                                        <th>Lựa chọn</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        @if(count($danhSachChiTiet) >0)
                                            <div class="row">
                                                <div class="col-md-12" style="text-align: center; margin-top:20px">
                                                    <button type="submit" class="btn btn-primary" style="width:40%">Thêm chi
                                                        tiết sản phẩm có thông tin sẵn</button>
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            {{-- Xác nhận xóa --}}
                            <div class="popup xacnhanxoa">
                                <div class="bg-popup"></div>
                                <div class="form-popup" style="width: auto">
                                    <div class="row-popup">
                                        <h3 style="color:red;text-align: center;">Xóa chi tiết sản phẩm</h3>
                                    </div>
                                    <form method="post" action="#" id="formdelete">
                                        @csrf
                                        @method('DELETE')
                                        <h4 style="display:block">Bạn có muốn xóa chi tiết sản phẩm này không
                                            ?</h4>
                                        <p style="margin-top: 10px; text-align: center">
                                            <button type="submit" class="btn btn-outline-danger">Có</button>
                                            <button type="button" class="btn btn-outline-secondary formclose">Không</button>
                                        </p>

                                    </form>
                                </div>
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
        const a = this.document.querySelector('.add-brand');
        const popup = this.document.querySelector('.popup');
        const html = this.document.querySelector('html');
        const btnclose = this.document.querySelector('.form-popup .row-popup button');
        const body = this.document.querySelector('body');
        //Hiển thị form thêm thương hiệu
        a.onclick = function() {
            popup.className += " active";
            html.style = "overflow: hidden;";
        };

        //Đóng form
        btnclose.onclick = function() {
            popup.className = popup.className.replace(" active", "");
            html.style = "overflow: auto;";
        };

        //Lấy thành phần form thêm chi tiết sản phẩm
        const btnthemchitiet = this.document.querySelector('.add-detail');
        const popupthemchitiet = this.document.querySelector('.popup.themchitiet');
        const btnclosethemchitiet = this.document.querySelector('.popup.themchitiet .form-popup .row-popup button');
        //Hiển thị form thêm chi tiết sản phẩm
        btnthemchitiet.onclick = function() {
            popupthemchitiet.className += " active";
            body.style = "overflow: hidden;";
        };

        //Đóng form thêm chi tiết sản phẩm
        btnclosethemchitiet.onclick = function() {
            popupthemchitiet.className = popupthemchitiet.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        //Đóng thông báo kết quả
        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }

        //Xác nhận xóa
        const popupxacnhaxoa = this.document.querySelector('.popup.xacnhanxoa');
        const btnclosexacnhanxoa = this.document.querySelector('.formclose');
        //Hiển thị
        function confirm($url) {
            popupxacnhaxoa.className += " active";
            body.style = "overflow: hidden;";
            $('#formdelete').attr('action', $url);
        };
        //Đóng
        btnclosexacnhanxoa.onclick = function() {
            popupxacnhaxoa.className = popupxacnhaxoa.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
    </script>
@endsection
