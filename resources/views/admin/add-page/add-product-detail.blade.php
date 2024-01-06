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
                    <h4 class="page-title">Thêm chi tiết sản phẩm</h4>
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
                                    <hr>
                                    <form action="{{ route('chiTietDienThoai.store') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                        @csrf
                                        <input type="hidden" name="dienthoaiid" value='{{ $dienThoai->id }}'>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="card-title">CHI TIẾT SẢN PHẨM MỚI</h4>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Màn hình <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="manhinh"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachManHinh as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->cong_nghe_man_hinh }} -
                                                                                {{ $tp->do_phan_giai }} -
                                                                                {{ $tp->man_hinh_rong }} -
                                                                                {{ $tp->do_sang_toi_da }} -
                                                                                {{ $tp->mat_kinh_cam_ung }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachManHinh as $tp)
                                                                            @if ($chiTietDienThoai->man_hinh_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->cong_nghe_man_hinh }} -
                                                                                    {{ $tp->do_phan_giai }} -
                                                                                    {{ $tp->man_hinh_rong }} -
                                                                                    {{ $tp->do_sang_toi_da }} -
                                                                                    {{ $tp->mat_kinh_cam_ung }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->cong_nghe_man_hinh }} -
                                                                                    {{ $tp->do_phan_giai }} -
                                                                                    {{ $tp->man_hinh_rong }} -
                                                                                    {{ $tp->do_sang_toi_da }} -
                                                                                    {{ $tp->mat_kinh_cam_ung }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary add-manhinh"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Camera Sau <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="camerasau"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachCameraSau as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->do_phan_giai }} -
                                                                                {{ $tp->quay_phim }} -
                                                                                {{ $tp->den_flash }} -
                                                                                {{ $tp->tinh_nang }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachCameraSau as $tp)
                                                                            @if ($chiTietDienThoai->camera_sau_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->do_phan_giai }} -
                                                                                    {{ $tp->quay_phim }} -
                                                                                    {{ $tp->den_flash }} -
                                                                                    {{ $tp->tinh_nang }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->do_phan_giai }} -
                                                                                    {{ $tp->quay_phim }} -
                                                                                    {{ $tp->den_flash }} -
                                                                                    {{ $tp->tinh_nang }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-camerasau"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Camera Trước <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="cameratruoc"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachCameraTruoc as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->do_phan_giai }} -
                                                                                {{ $tp->tinh_nang }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachCameraTruoc as $tp)
                                                                            @if ($chiTietDienThoai->camera_truoc_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->do_phan_giai }} -
                                                                                    {{ $tp->tinh_nang }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->do_phan_giai }} -
                                                                                    {{ $tp->tinh_nang }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-cameratruoc"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Hệ điều hành - CPU <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="hedieuhanh"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachHeDieuHanh as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->he_dieu_hanh }} -
                                                                                {{ $tp->chip_xu_ly }} -
                                                                                {{ $tp->toc_do_cpu }} -
                                                                                {{ $tp->chip_do_hoa }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachHeDieuHanh as $tp)
                                                                            @if ($chiTietDienThoai->he_dieu_hanh_cpu_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->he_dieu_hanh }} -
                                                                                    {{ $tp->chip_xu_ly }} -
                                                                                    {{ $tp->toc_do_cpu }} -
                                                                                    {{ $tp->chip_do_hoa }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->he_dieu_hanh }} -
                                                                                    {{ $tp->chip_xu_ly }} -
                                                                                    {{ $tp->toc_do_cpu }} -
                                                                                    {{ $tp->chip_do_hoa }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-hedieuhanh"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Bộ nhớ lưu trữ <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="bonholuutru"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachBoNho as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->ram }} -
                                                                                {{ $tp->bo_nho_trong }} -
                                                                                {{ $tp->bo_nho_con_lai }} -
                                                                                {{ $tp->the_nho }} -
                                                                                {{ $tp->danh_ba }}
                                                                            </option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachBoNho as $tp)
                                                                            @if ($chiTietDienThoai->bo_nho_luu_tru_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->ram }} -
                                                                                    {{ $tp->bo_nho_trong }} -
                                                                                    {{ $tp->bo_nho_con_lai }} -
                                                                                    {{ $tp->the_nho }} -
                                                                                    {{ $tp->danh_ba }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->ram }} -
                                                                                    {{ $tp->bo_nho_trong }} -
                                                                                    {{ $tp->bo_nho_con_lai }} -
                                                                                    {{ $tp->the_nho }} -
                                                                                    {{ $tp->danh_ba }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-bonho"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Kết nối <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="ketnoi"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachKetNoi as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->mang_di_dong }} -
                                                                                {{ $tp->sim }} - {{ $tp->wifi }}
                                                                                -
                                                                                {{ $tp->gps }} -
                                                                                {{ $tp->bluetooth }} -
                                                                                {{ $tp->cong_ket_noi }} -
                                                                                {{ $tp->jack_tai_nghe }} -
                                                                                {{ $tp->ket_noi_khac }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachKetNoi as $tp)
                                                                            @if ($chiTietDienThoai->ket_noi_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->mang_di_dong }} -
                                                                                    {{ $tp->sim }} -
                                                                                    {{ $tp->wifi }}
                                                                                    -
                                                                                    {{ $tp->gps }} -
                                                                                    {{ $tp->bluetooth }} -
                                                                                    {{ $tp->cong_ket_noi }} -
                                                                                    {{ $tp->jack_tai_nghe }} -
                                                                                    {{ $tp->ket_noi_khac }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->mang_di_dong }} -
                                                                                    {{ $tp->sim }} -
                                                                                    {{ $tp->wifi }}
                                                                                    -
                                                                                    {{ $tp->gps }} -
                                                                                    {{ $tp->bluetooth }} -
                                                                                    {{ $tp->cong_ket_noi }} -
                                                                                    {{ $tp->jack_tai_nghe }} -
                                                                                    {{ $tp->ket_noi_khac }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-ketnoi"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Pin sạc <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="pinsac"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachPin as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->dung_luong_pin }} -
                                                                                {{ $tp->loai_pin }} -
                                                                                {{ $tp->ho_tro_sac_toi_da }} -
                                                                                {{ $tp->sac_kem_theo_may }} -
                                                                                {{ $tp->cong_nghe_pin }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachPin as $tp)
                                                                            @if ($chiTietDienThoai->pin_sac_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->dung_luong_pin }} -
                                                                                    {{ $tp->loai_pin }} -
                                                                                    {{ $tp->ho_tro_sac_toi_da }} -
                                                                                    {{ $tp->sac_kem_theo_may }} -
                                                                                    {{ $tp->cong_nghe_pin }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->dung_luong_pin }} -
                                                                                    {{ $tp->loai_pin }} -
                                                                                    {{ $tp->ho_tro_sac_toi_da }} -
                                                                                    {{ $tp->sac_kem_theo_may }} -
                                                                                    {{ $tp->cong_nghe_pin }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-pin"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Tiện ích <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="tienich"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachTienIch as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->bao_mat_nang_cao }} -
                                                                                {{ $tp->tinh_nang_dac_biet }} -
                                                                                {{ $tp->khang_nuoc_bui }} -
                                                                                {{ $tp->ghi_am }} -
                                                                                {{ $tp->xem_phim }}
                                                                                -
                                                                                {{ $tp->nghe_nhac }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachTienIch as $tp)
                                                                            @if ($chiTietDienThoai->tien_ich_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->bao_mat_nang_cao }} -
                                                                                    {{ $tp->tinh_nang_dac_biet }} -
                                                                                    {{ $tp->khang_nuoc_bui }} -
                                                                                    {{ $tp->ghi_am }} -
                                                                                    {{ $tp->xem_phim }}
                                                                                    -
                                                                                    {{ $tp->nghe_nhac }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->bao_mat_nang_cao }} -
                                                                                    {{ $tp->tinh_nang_dac_biet }} -
                                                                                    {{ $tp->khang_nuoc_bui }} -
                                                                                    {{ $tp->ghi_am }} -
                                                                                    {{ $tp->xem_phim }}
                                                                                    -
                                                                                    {{ $tp->nghe_nhac }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-tienich"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Thông tin chung <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="thongtinchung"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @if (empty($chiTietDienThoai))
                                                                        @foreach ($danhSachThongTinChung as $tp)
                                                                            <option value="{{ $tp->id }}">
                                                                                {{ $tp->thiet_ke }} -
                                                                                {{ $tp->chat_lieu }}
                                                                                - {{ $tp->kich_thuoc_khoi_luong }} -
                                                                                {{ $tp->thoi_diem_ra_mat }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($danhSachThongTinChung as $tp)
                                                                            @if ($chiTietDienThoai->thong_tin_chung_id == $tp->id)
                                                                                <option value="{{ $tp->id }}"
                                                                                    selected>
                                                                                    {{ $tp->thiet_ke }} -
                                                                                    {{ $tp->chat_lieu }}
                                                                                    - {{ $tp->kich_thuoc_khoi_luong }} -
                                                                                    {{ $tp->thoi_diem_ra_mat }}</option>
                                                                            @else
                                                                                <option value="{{ $tp->id }}">
                                                                                    {{ $tp->thiet_ke }} -
                                                                                    {{ $tp->chat_lieu }}
                                                                                    - {{ $tp->kich_thuoc_khoi_luong }} -
                                                                                    {{ $tp->thoi_diem_ra_mat }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-thongtinchung"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Màu sắc <span
                                                                    style="color:red">*</span>
                                                            </label>
                                                            <div class="col-sm-11" style="z-index: 1">
                                                                <select name="mausac"
                                                                    class="select2 form-select shadow-none select2-hidden-accessible"
                                                                    style="width: 100%; height:36px;" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    @foreach ($danhSachMauSac as $tp)
                                                                        <option value="{{ $tp->id }}">
                                                                            {{ $tp->ten_mau_sac }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <button type="button" class="btn btn-outline-secondary add-mausac"
                                                                style="width: 40px;">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12">Giá sản phẩm <span
                                                                    style="color:red">*</span></label>
                                                            <div>
                                                                <input class="form-control" name="gia" type="number"
                                                                    style="height: 40px; width: 95%; float: left;"
                                                                    id="product_price" placeholder="0" value="" min="0" required>
                                                                <div
                                                                    style="background-color: #ebebeb;padding: 8.5px;text-align: center;border-radius: 3px;border: 1px solid #ccc;">
                                                                    đ</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: center; margin-top: 20px">
                                                <button type="submit" class="btn btn-primary">Thêm chi tiết sản
                                                    phẩm</button>
                                            </div>
                                        </div>
                                    </form>
                        </div>
                        {{-- Form thêm màn hình --}}
                        <div class="popup themmanhinh">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm màn hình</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('manHinh.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Công nghệ màn hình<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="congnghemanhinh"
                                                                type="text" style="height: 40px;"
                                                                placeholder="Công nghệ màn hình" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Độ phân giải<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="dophangiai" type="text"
                                                                style="height: 40px;" placeholder="Độ phân giải" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Màn hình rộng<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="manhinhrong" type="text"
                                                                style="height: 40px;" placeholder="Màn hình rộng" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Độ sáng tối đa<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="dosangtoida" type="text"
                                                                style="height: 40px;" placeholder="Độ sáng tối đa" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Mặt kính cảm ứng<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="matkinhcamung" type="text"
                                                                style="height: 40px;" placeholder="Mặt kính cảm ứng"
                                                                value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm màn hình</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm camera sau --}}
                        <div class="popup themcamerasau">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm camera sau</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('cameraSau.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Độ phân giải<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="dophangiai" type="text"
                                                                style="height: 40px;" placeholder="Độ phân giải" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Quay phim<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="quayphim" type="text"
                                                                style="height: 40px;" placeholder="Quay phim" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Đèn flash<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="denflash" type="text"
                                                                style="height: 40px;" placeholder="Đèn flash" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tính năng<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tinhnang" type="text"
                                                                style="height: 40px;" placeholder="Tính năng" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm camera sau</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm camera trước --}}
                        <div class="popup themcameratruoc">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm camera trước</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('cameraTruoc.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Độ phân giải<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="dophangiai" type="text"
                                                                style="height: 40px;" placeholder="Độ phân giải" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tính năng<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tinhnang" type="text"
                                                                style="height: 40px;" placeholder="Tính năng" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm camera trước</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm hệ điều hành --}}
                        <div class="popup themhedieuhanh">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm hệ điều hành- CPU</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('heDieuHanh_CPU.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Hệ điều hành<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="hedieuhanh" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Hệ điều hành" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Chip xử lý<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="chipxuly" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Chip xử lý" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tốc độ cpu<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tocdocpu" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Tốc độ cpu" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Chip đồ họa<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="chipdohoa" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Chip đồ họa" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm hệ điều hành - CPU</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm bộ nhớ --}}
                        <div class="popup thembonho">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm bộ nhớ lưu trữ</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('boNho_LuuTru.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Ram<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="ram" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Ram" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Bộ nhớ trong<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="bonhotrong" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Bộ nhớ trong" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Bộ nhớ còn lại<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="bonhoconlai" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Bộ nhớ còn lại" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Thẻ nhớ<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="thenho" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Thẻ nhớ" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Danh bạ<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="danhba" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Danh bạ" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm hệ bộ nhớ lưu trữ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm kết nối --}}
                        <div class="popup themketnoi">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm kết nối</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('ketNoi.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
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
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm kết nối</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm pin --}}
                        <div class="popup thempin">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm pin sạc</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('pin_Sac.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Dung lượng pin<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="dungluongpin" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Dung lượng pin" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Loại pin<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="loaipin" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Loại pin" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Hỗ trợ sạc tối đa<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="hotrosactoida" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Hỗ trợ sạc tối đa" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Sạc kèm theo máy<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="sackemtheomay" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Sạc kèm theo máy" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Công nghệ pin<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="congnghepin" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Công nghệ pin" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm pin sạc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm tiện ích --}}
                        <div class="popup themtienich">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm tiện ích</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('tienIch.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Bảo mật nâng cao<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="baomatnangcao" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Bảo mật nâng cao" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tính năng đặt biệt<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tinhnangdacbiet" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Tính năng đặt biệt" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Kháng nước bụi<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="khangnuocbui" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Kháng nước bụi" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Ghi âm<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="ghiam" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Xem phim" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Xem phim<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="xemphim" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Xem phim" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Nghe nhạc<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="nghenhac" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Nghe nhạc" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm tiện ích</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm thông tin chung --}}
                        <div class="popup themthongtinchung">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm thông tin chung</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('thongTinChung.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Thiết kế<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="thietke" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Thiết kế" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Chất liệu<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="chatlieu" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Chất liệu" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Kích thước khối lượng<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="kichthuockhoiluong" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Kích thước khối lượng" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Thời điểm ra mắt<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="thoidiemramat" type="date"
                                                                style="height: 40px;"
                                                                placeholder="Thời điểm ra mắt" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm thông tin chung</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

                        {{-- Form thêm màu sắc --}}
                        <div class="popup themmausac">
                            <div class="bg-popup"></div>
                            <div class="form-popup">
                                <div class="row-popup">
                                    <strong style="font-size: 18px">Thêm màu sắc</strong>
                                    <button>Đóng</button>
                                </div>
                                <form action="{{ route('mauSac.store') }}" enctype="multipart/form-data" method="post"
                                    accept-charset="utf-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12">Tên màu<span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="tenmausac" type="text"
                                                                style="height: 40px;"
                                                                placeholder="Tên màu" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center; margin-top:10px;margin-bottom:10px">
                                            <button type="submit" class="btn btn-primary">Thêm màu sắc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- Kết thúc form --}}

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

    <script type="text/javascript">
        const body = this.document.querySelector('body');
        //Lấy thành phần form
        const btnthemmanhinh = this.document.querySelector('.add-manhinh');
        const popupthemmanhinh = this.document.querySelector('.popup.themmanhinh');
        const btnclosethemmanhinh = this.document.querySelector('.popup.themmanhinh .form-popup .row-popup button');

        const btnthemcamerasau = this.document.querySelector('.add-camerasau');
        const popupthemcamerasau = this.document.querySelector('.popup.themcamerasau');
        const btnclosethemcamerasau = this.document.querySelector('.popup.themcamerasau .form-popup .row-popup button');

        const btnthemcameratruoc = this.document.querySelector('.add-cameratruoc');
        const popupthemcameratruoc = this.document.querySelector('.popup.themcameratruoc');
        const btnclosethemcameratruoc = this.document.querySelector('.popup.themcameratruoc .form-popup .row-popup button');

        const btnthemhedieuhanh = this.document.querySelector('.add-hedieuhanh');
        const popupthemhedieuhanh = this.document.querySelector('.popup.themhedieuhanh');
        const btnclosethemhedieuhanh = this.document.querySelector('.popup.themhedieuhanh .form-popup .row-popup button');

        const btnthembonho = this.document.querySelector('.add-bonho');
        const popupthembonho = this.document.querySelector('.popup.thembonho');
        const btnclosethembonho = this.document.querySelector('.popup.thembonho .form-popup .row-popup button');

        const btnthemketnoi= this.document.querySelector('.add-ketnoi');
        const popupthemketnoi = this.document.querySelector('.popup.themketnoi');
        const btnclosethemketnoi = this.document.querySelector('.popup.themketnoi .form-popup .row-popup button');

        const btnthempin= this.document.querySelector('.add-pin');
        const popupthempin = this.document.querySelector('.popup.thempin');
        const btnclosethempin = this.document.querySelector('.popup.thempin .form-popup .row-popup button');

        const btnthemtienich= this.document.querySelector('.add-tienich');
        const popupthemtienich = this.document.querySelector('.popup.themtienich');
        const btnclosethemtienich = this.document.querySelector('.popup.themtienich .form-popup .row-popup button');

        const btnthemthongtinchung = this.document.querySelector('.add-thongtinchung');
        const popupthemthongtinchung = this.document.querySelector('.popup.themthongtinchung');
        const btnclosethemthongtinchung = this.document.querySelector('.popup.themthongtinchung .form-popup .row-popup button');

        const btnthemmausac = this.document.querySelector('.add-mausac');
        const popupthemmausac = this.document.querySelector('.popup.themmausac');
        const btnclosethemmausac = this.document.querySelector('.popup.themmausac .form-popup .row-popup button');
        //Hiển thị form thêm
        btnthemmanhinh.onclick = function() {
            popupthemmanhinh.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemcamerasau.onclick = function() {
            popupthemcamerasau.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemcameratruoc.onclick = function() {
            popupthemcameratruoc.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemhedieuhanh.onclick = function() {
            popupthemhedieuhanh.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthembonho.onclick = function() {
            popupthembonho.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemketnoi.onclick = function() {
            popupthemketnoi.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthempin.onclick = function() {
            popupthempin.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemtienich.onclick = function() {
            popupthemtienich.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemthongtinchung.onclick = function() {
            popupthemthongtinchung.className += " active";
            body.style = "overflow: hidden;";
        };
        btnthemmausac.onclick = function() {
            popupthemmausac.className += " active";
            body.style = "overflow: hidden;";
        };


        //Đóng form thêm
        btnclosethemmanhinh.onclick = function() {
            popupthemmanhinh.className = popupthemmanhinh.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemcamerasau.onclick = function() {
            popupthemcamerasau.className = popupthemcamerasau.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemcameratruoc.onclick = function() {
            popupthemcameratruoc.className = popupthemcameratruoc.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemhedieuhanh.onclick = function() {
            popupthemhedieuhanh.className = popupthemhedieuhanh.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethembonho.onclick = function() {
            popupthembonho.className = popupthembonho.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemketnoi.onclick = function() {
            popupthemketnoi.className = popupthemketnoi.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethempin.onclick = function() {
            popupthempin.className = popupthempin.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemtienich.onclick = function() {
            popupthemtienich.className = popupthemtienich.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemthongtinchung.onclick = function() {
            popupthemthongtinchung.className = popupthemthongtinchung.className.replace(" active", "");
            body.style = "overflow: auto;";
        };
        btnclosethemmausac.onclick = function() {
            popupthemmausac.className = popupthemmausac.className.replace(" active", "");
            body.style = "overflow: auto;";
        };

        function closepopup() {
            const popup = this.document.querySelector('.popup.active.ketqua');
            popup.className = popup.className.replace(" active", "");
            body.style = "overflow: auto;";
        }
    </script>
@endsection
