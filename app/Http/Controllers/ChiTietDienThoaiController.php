<?php

namespace App\Http\Controllers;

use App\Models\DienThoai;
use App\Models\ChiTietDienThoai;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\ManHinh;
use App\Models\MauSac;
use App\Models\CameraSau;
use App\Models\CameraTruoc;
use App\Models\BoNho_LuuTru;
use App\Models\ThongTinChung;
use App\Models\TienIch;
use App\Models\Pin_Sac;
use App\Models\KetNoi;
use App\Models\HeDieuHanh_CPU;
use App\Models\DanhGia;
use App\Models\HinhAnhMauSacCuaDienThoai;
use App\Models\HinhAnhChungCuaDienThoai;
use App\Models\PhanHoiDanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChiTietDienThoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChiTietDienThoaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Kiểm tra id màn hình
        $danhSachManHinh = ManHinh::All();
        $chuoiIdMH = '';
        $dem = 0;
        foreach ($danhSachManHinh as $tp) {
            if ($dem == 0) {
                $chuoiIdMH = $tp->id;
            } else {
                $chuoiIdMH = $chuoiIdMH . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id màu sắc
        $danhSachMauSac = MauSac::All();
        $chuoiIdMS = '';
        $dem = 0;
        foreach ($danhSachMauSac as $tp) {
            if ($dem == 0) {
                $chuoiIdMS = $tp->id;
            } else {
                $chuoiIdMS = $chuoiIdMS . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id camera sau
        $danhSachCameraSau = CameraSau::All();
        $chuoiIdCMRS = '';
        $dem = 0;
        foreach ($danhSachCameraSau as $tp) {
            if ($dem == 0) {
                $chuoiIdCMRS = $tp->id;
            } else {
                $chuoiIdCMRS = $chuoiIdCMRS . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id camera trước
        $danhSachCameraTruoc = CameraTruoc::All();
        $chuoiIdCMRT = '';
        $dem = 0;
        foreach ($danhSachCameraTruoc as $tp) {
            if ($dem == 0) {
                $chuoiIdCMRT = $tp->id;
            } else {
                $chuoiIdCMRT = $chuoiIdCMRT . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id hệ điều hành
        $danhSachHeDieuHanh = HeDieuHanh_CPU::All();
        $chuoiIdHDH = '';
        $dem = 0;
        foreach ($danhSachHeDieuHanh as $tp) {
            if ($dem == 0) {
                $chuoiIdHDH = $tp->id;
            } else {
                $chuoiIdHDH = $chuoiIdHDH . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id bộ nhớ
        $danhSachBoNho = BoNho_LuuTru::All();
        $chuoiIdBN = '';
        $dem = 0;
        foreach ($danhSachBoNho as $tp) {
            if ($dem == 0) {
                $chuoiIdBN = $tp->id;
            } else {
                $chuoiIdBN = $chuoiIdBN . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id kết nối
        $danhSachKetNoi = KetNoi::All();
        $chuoiIdKN = '';
        $dem = 0;
        foreach ($danhSachKetNoi as $tp) {
            if ($dem == 0) {
                $chuoiIdKN = $tp->id;
            } else {
                $chuoiIdKN = $chuoiIdKN . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id pin
        $danhSachPin = Pin_Sac::All();
        $chuoiIdPin = '';
        $dem = 0;
        foreach ($danhSachPin as $tp) {
            if ($dem == 0) {
                $chuoiIdPin = $tp->id;
            } else {
                $chuoiIdPin = $chuoiIdPin . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id tiện ích
        $danhSachTienIch = TienIch::All();
        $chuoiIdTienIch = '';
        $dem = 0;
        foreach ($danhSachTienIch as $tp) {
            if ($dem == 0) {
                $chuoiIdTienIch = $tp->id;
            } else {
                $chuoiIdTienIch = $chuoiIdTienIch . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id thông tin chung
        $danhSachThongTinChung = ThongTinChung::All();
        $chuoiIdTTC = '';
        $dem = 0;
        foreach ($danhSachThongTinChung as $tp) {
            if ($dem == 0) {
                $chuoiIdTTC = $tp->id;
            } else {
                $chuoiIdTTC = $chuoiIdTTC . ',' . $tp->id;
            }
            $dem++;
        }

        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'manhinh' => 'required|in:' . $chuoiIdMH,
                'camerasau' => 'required|in:' . $chuoiIdCMRS,
                'cameratruoc' => 'required|in:' . $chuoiIdCMRT,
                'hedieuhanh' => 'required|in:' . $chuoiIdHDH,
                'bonholuutru' => 'required|in:' . $chuoiIdBN,
                'ketnoi' => 'required|in:' . $chuoiIdKN,
                'pinsac' => 'required|in:' . $chuoiIdPin,
                'tienich' => 'required|in:' . $chuoiIdTienIch,
                'thongtinchung' => 'required|in:' . $chuoiIdTTC,
                'mausac' => 'required|in:' . $chuoiIdMS,
                'gia' => 'required|numeric|min:0',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'manhinh' => 'Màn hình',
                'camerasau' => 'Camera sau',
                'cameratruoc' => 'Camera trước',
                'hedieuhanh' => 'Hệ điều hành',
                'bonholuutru' => 'Bộ nhớ lưu trữ',
                'ketnoi' => 'Kết nối',
                'pinsac' => 'Pin sạc',
                'tienich' => 'Tiện ích',
                'thongtinchung' => 'Thông tin chung',
                'mausac' => 'Màu sắc',
                'gia' => 'Giá',
            ]
        )->validate();

        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        $chiTietDienThoai = new ChiTietDienThoai();
        $chiTietDienThoai->fill([
            'dien_thoai_id' => $request->input('dienthoaiid'),
            'man_hinh_id' => $request->input('manhinh'),
            'camera_sau_id' => $request->input('camerasau'),
            'camera_truoc_id' => $request->input('cameratruoc'),
            'he_dieu_hanh_cpu_id' => $request->input('hedieuhanh'),
            'bo_nho_luu_tru_id' => $request->input('bonholuutru'),
            'ket_noi_id' => $request->input('ketnoi'),
            'pin_sac_id' => $request->input('pinsac'),
            'tien_ich_id' => $request->input('tienich'),
            'thong_tin_chung_id' => $request->input('thongtinchung'),
            'mau_sac_id' => $request->input('mausac'),
            'gia' => $request->input('gia'),
        ]);
        if ($chiTietDienThoai->save() == true) {
            $kTMauSac = ChiTietDienThoai::where('dien_thoai_id', '=', $chiTietDienThoai->dien_thoai_id)
                ->where('mau_sac_id', '=', $chiTietDienThoai->mau_sac_id)
                ->where('id', '!=', $chiTietDienThoai->id)
                ->first();
            if (empty($kTMauSac)) {
                $hinhAnhMauSac = new HinhAnhMauSacCuaDienThoai();
                $hinhAnhMauSac->fill([
                    'dien_thoai_id' => $chiTietDienThoai->dien_thoai_id,
                    'mau_sac_id' => $chiTietDienThoai->mau_sac_id,
                    'hinh_anh_dai_dien' => 1,
                    'hinh_anh' => 'default/default.png',
                ]);
                if ($hinhAnhMauSac->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm chi tiết sản phẩm thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm chi tiết sản phẩm không thành công ! Hình ảnh màu sắc đại diện của chi tiết có lỗi khi thêm vào hệ thống !');
            }
            return redirect()->back()->with('thongbao', 'Thêm chi tiết sản phẩm thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm chi tiết sản phẩm không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChiTietDienThoai  $chiTietDienThoai
     * @return \Illuminate\Http\Response
     */
    public function show(ChiTietDienThoai $chiTietDienThoai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChiTietDienThoai  $chiTietDienThoai
     * @return \Illuminate\Http\Response
     */
    public function edit(ChiTietDienThoai $chiTietDienThoai)
    {
        $danhSachManHinh = ManHinh::All();
        $danhSachMauSac = MauSac::All();
        $danhSachCameraSau = CameraSau::All();
        $danhSachCameraTruoc = CameraTruoc::All();
        $danhSachHeDieuHanh = HeDieuHanh_CPU::All();
        $danhSachBoNho = BoNho_LuuTru::All();
        $danhSachKetNoi = KetNoi::All();
        $danhSachTienIch = TienIch::All();
        $danhSachThongTinChung = ThongTinChung::All();
        $danhSachPin = Pin_Sac::All();
        $dienThoai = DienThoai::where('id', '=', $chiTietDienThoai->dien_thoai_id)->first();
        return view('admin/edit-page/edit-product-detail', [
            'chiTietDienThoai' => $chiTietDienThoai, 'dienThoai' => $dienThoai, 'danhSachManHinh' => $danhSachManHinh, 'danhSachMauSac' => $danhSachMauSac, 'danhSachCameraSau' => $danhSachCameraSau, 'danhSachCameraTruoc' => $danhSachCameraTruoc, 'danhSachHeDieuHanh' => $danhSachHeDieuHanh, 'danhSachBoNho' => $danhSachBoNho, 'danhSachKetNoi' => $danhSachKetNoi, 'danhSachTienIch' => $danhSachTienIch, 'danhSachThongTinChung' => $danhSachThongTinChung, 'danhSachPin' => $danhSachPin
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChiTietDienThoaiRequest  $request
     * @param  \App\Models\ChiTietDienThoai  $chiTietDienThoai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChiTietDienThoai $chiTietDienThoai)
    {
        // Kiểm tra id màn hình
        $danhSachManHinh = ManHinh::All();
        $chuoiIdMH = '';
        $dem = 0;
        foreach ($danhSachManHinh as $tp) {
            if ($dem == 0) {
                $chuoiIdMH = $tp->id;
            } else {
                $chuoiIdMH = $chuoiIdMH . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id màu sắc
        $danhSachMauSac = MauSac::All();
        $chuoiIdMS = '';
        $dem = 0;
        foreach ($danhSachMauSac as $tp) {
            if ($dem == 0) {
                $chuoiIdMS = $tp->id;
            } else {
                $chuoiIdMS = $chuoiIdMS . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id camera sau
        $danhSachCameraSau = CameraSau::All();
        $chuoiIdCMRS = '';
        $dem = 0;
        foreach ($danhSachCameraSau as $tp) {
            if ($dem == 0) {
                $chuoiIdCMRS = $tp->id;
            } else {
                $chuoiIdCMRS = $chuoiIdCMRS . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id camera trước
        $danhSachCameraTruoc = CameraTruoc::All();
        $chuoiIdCMRT = '';
        $dem = 0;
        foreach ($danhSachCameraTruoc as $tp) {
            if ($dem == 0) {
                $chuoiIdCMRT = $tp->id;
            } else {
                $chuoiIdCMRT = $chuoiIdCMRT . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id hệ điều hành
        $danhSachHeDieuHanh = HeDieuHanh_CPU::All();
        $chuoiIdHDH = '';
        $dem = 0;
        foreach ($danhSachHeDieuHanh as $tp) {
            if ($dem == 0) {
                $chuoiIdHDH = $tp->id;
            } else {
                $chuoiIdHDH = $chuoiIdHDH . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id bộ nhớ
        $danhSachBoNho = BoNho_LuuTru::All();
        $chuoiIdBN = '';
        $dem = 0;
        foreach ($danhSachBoNho as $tp) {
            if ($dem == 0) {
                $chuoiIdBN = $tp->id;
            } else {
                $chuoiIdBN = $chuoiIdBN . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id kết nối
        $danhSachKetNoi = KetNoi::All();
        $chuoiIdKN = '';
        $dem = 0;
        foreach ($danhSachKetNoi as $tp) {
            if ($dem == 0) {
                $chuoiIdKN = $tp->id;
            } else {
                $chuoiIdKN = $chuoiIdKN . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id pin
        $danhSachPin = Pin_Sac::All();
        $chuoiIdPin = '';
        $dem = 0;
        foreach ($danhSachPin as $tp) {
            if ($dem == 0) {
                $chuoiIdPin = $tp->id;
            } else {
                $chuoiIdPin = $chuoiIdPin . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id tiện ích
        $danhSachTienIch = TienIch::All();
        $chuoiIdTienIch = '';
        $dem = 0;
        foreach ($danhSachTienIch as $tp) {
            if ($dem == 0) {
                $chuoiIdTienIch = $tp->id;
            } else {
                $chuoiIdTienIch = $chuoiIdTienIch . ',' . $tp->id;
            }
            $dem++;
        }

        // Kiểm tra id thông tin chung
        $danhSachThongTinChung = ThongTinChung::All();
        $chuoiIdTTC = '';
        $dem = 0;
        foreach ($danhSachThongTinChung as $tp) {
            if ($dem == 0) {
                $chuoiIdTTC = $tp->id;
            } else {
                $chuoiIdTTC = $chuoiIdTTC . ',' . $tp->id;
            }
            $dem++;
        }

        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'manhinh' => 'required|in:' . $chuoiIdMH,
                'camerasau' => 'required|in:' . $chuoiIdCMRS,
                'cameratruoc' => 'required|in:' . $chuoiIdCMRT,
                'hedieuhanh' => 'required|in:' . $chuoiIdHDH,
                'bonholuutru' => 'required|in:' . $chuoiIdBN,
                'ketnoi' => 'required|in:' . $chuoiIdKN,
                'pinsac' => 'required|in:' . $chuoiIdPin,
                'tienich' => 'required|in:' . $chuoiIdTienIch,
                'thongtinchung' => 'required|in:' . $chuoiIdTTC,
                'mausac' => 'required|in:' . $chuoiIdMS,
                'gia' => 'required|numeric|min:0',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'in' => ':attribute không đúng với dữ liệu hệ thống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'manhinh' => 'Màn hình',
                'camerasau' => 'Camera sau',
                'cameratruoc' => 'Camera trước',
                'hedieuhanh' => 'Hệ điều hành',
                'bonholuutru' => 'Bộ nhớ lưu trữ',
                'ketnoi' => 'Kết nối',
                'pinsac' => 'Pin sạc',
                'tienich' => 'Tiện ích',
                'thongtinchung' => 'Thông tin chung',
                'mausac' => 'Màu sắc',
                'gia' => 'Giá',
            ]
        )->validate();

        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        $chiTietDienThoai->fill([
            'dien_thoai_id' => $request->input('dienthoaiid'),
            'man_hinh_id' => $request->input('manhinh'),
            'camera_sau_id' => $request->input('camerasau'),
            'camera_truoc_id' => $request->input('cameratruoc'),
            'he_dieu_hanh_cpu_id' => $request->input('hedieuhanh'),
            'bo_nho_luu_tru_id' => $request->input('bonholuutru'),
            'ket_noi_id' => $request->input('ketnoi'),
            'pin_sac_id' => $request->input('pinsac'),
            'tien_ich_id' => $request->input('tienich'),
            'thong_tin_chung_id' => $request->input('thongtinchung'),
            'mau_sac_id' => $request->input('mausac'),
            'gia' => $request->input('gia'),
        ]);
        if ($chiTietDienThoai->save() == true) {
            $kTMauSac = ChiTietDienThoai::where('dien_thoai_id', '=', $chiTietDienThoai->dien_thoai_id)
                ->where('mau_sac_id', '=', $chiTietDienThoai->mau_sac_id)
                ->where('id', '!=', $chiTietDienThoai->id)
                ->first();
            if (empty($kTMauSac)) {
                $hinhAnhMauSac = new HinhAnhMauSacCuaDienThoai();
                $hinhAnhMauSac->fill([
                    'dien_thoai_id' => $chiTietDienThoai->dien_thoai_id,
                    'mau_sac_id' => $chiTietDienThoai->mau_sac_id,
                    'hinh_anh_dai_dien' => 1,
                    'hinh_anh' => 'default/default.png',
                ]);
                if ($hinhAnhMauSac->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật chi tiết sản phẩm thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật chi tiết sản phẩm không thành công ! Hình ảnh màu sắc đại diện của chi tiết có lỗi khi thêm vào hệ thống !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật chi tiết sản phẩm thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật chi tiết sản phẩm không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChiTietDienThoai  $chiTietDienThoai
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChiTietDienThoai $chiTietDienThoai)
    {
        if ($chiTietDienThoai->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa chi tiết sản phẩm thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa chi tiết sản phẩm không thành công !');
    }

    public function createChiTietSanPham(Request $request)
    {
        $danhSachManHinh = ManHinh::All();
        $danhSachMauSac = MauSac::All();
        $danhSachCameraSau = CameraSau::All();
        $danhSachCameraTruoc = CameraTruoc::All();
        $danhSachHeDieuHanh = HeDieuHanh_CPU::All();
        $danhSachBoNho = BoNho_LuuTru::All();
        $danhSachKetNoi = KetNoi::All();
        $danhSachTienIch = TienIch::All();
        $danhSachThongTinChung = ThongTinChung::All();
        $danhSachPin = Pin_Sac::All();
        $dienThoai = DienThoai::where('id', '=', $request->sanPhamId)->first();
        if ($request->loaiThem == 0) {
            return view('admin/add-page/add-product-detail', [
                'dienThoai' => $dienThoai, 'danhSachManHinh' => $danhSachManHinh, 'danhSachMauSac' => $danhSachMauSac, 'danhSachCameraSau' => $danhSachCameraSau, 'danhSachCameraTruoc' => $danhSachCameraTruoc, 'danhSachHeDieuHanh' => $danhSachHeDieuHanh, 'danhSachBoNho' => $danhSachBoNho, 'danhSachKetNoi' => $danhSachKetNoi, 'danhSachTienIch' => $danhSachTienIch, 'danhSachThongTinChung' => $danhSachThongTinChung, 'danhSachPin' => $danhSachPin
            ]);
        } else {
            $chiTietDienThoai = ChiTietDienThoai::where('id', '=', $request->chitietsanpham)->first();
            return view('admin/add-page/add-product-detail', [
                'dienThoai' => $dienThoai, 'chiTietDienThoai' => $chiTietDienThoai, 'danhSachManHinh' => $danhSachManHinh, 'danhSachMauSac' => $danhSachMauSac, 'danhSachCameraSau' => $danhSachCameraSau, 'danhSachCameraTruoc' => $danhSachCameraTruoc, 'danhSachHeDieuHanh' => $danhSachHeDieuHanh, 'danhSachBoNho' => $danhSachBoNho, 'danhSachKetNoi' => $danhSachKetNoi, 'danhSachTienIch' => $danhSachTienIch, 'danhSachThongTinChung' => $danhSachThongTinChung, 'danhSachPin' => $danhSachPin
            ]);
        }
    }

    public function productDetail($sanPhamId)
    {
        $dienThoai = DienThoai::where('id', '=', $sanPhamId)->first();
        $hinhAnhMoHop = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('loai_hinh', '=', 1)
            ->first();
        $hinhAnhThongSoKyThuat = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('loai_hinh', '=', 2)
            ->first();
        $danhSachHinhAnhNoiBat = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('loai_hinh', '=', 3)
            ->get();
        $danhSachHinhAnh360 = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('loai_hinh', '=', 4)
            ->get();
        $hinhAnhMauSacSanPhamDaiDien = HinhAnhMauSacCuaDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'hinh_anh_mau_sac_cua_dien_thoais.mau_sac_id')
            ->where('dien_thoai_id', '=', $sanPhamId)
            ->where('hinh_anh_dai_dien', '=', 1)
            ->select('hinh_anh_mau_sac_cua_dien_thoais.*', 'mau_sacs.ten_mau_sac')
            ->get();
        $danhSachHinhAnhMauSac = HinhAnhMauSacCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('hinh_anh_dai_dien', '=', 0)
            ->get();
        $danhSachChiTiet = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->where('dien_thoai_id', '=', $dienThoai->id)
            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
            ->get();
        foreach ($danhSachChiTiet as $tp) {
            $khuyenMai = ChiTietKhuyenMai::where('dien_thoai_id', '=', $sanPhamId)->first();
            if (!empty($khuyenMai)) {
                $thoiGianKhuyenMai = KhuyenMai::where('id', '=', $khuyenMai->khuyen_mai_id)->first();
                if (strtotime($thoiGianKhuyenMai->ngay_ket_thuc) >= strtotime(date("Y-m-d"))) {
                    $tp->phan_tram_giam = $khuyenMai->phan_tram_giam;
                } else {
                    $tp->phan_tram_giam = 0;
                }
            } else {
                $tp->phan_tram_giam = 0;
            }
        }
        $thongSoKyThuat = ChiTietDienThoai::join('man_hinhs', 'man_hinhs.id', '=', 'chi_tiet_dien_thoais.man_hinh_id')
            ->join('camera_saus', 'camera_saus.id', '=', 'chi_tiet_dien_thoais.camera_sau_id')
            ->join('camera_truocs', 'camera_truocs.id', '=', 'chi_tiet_dien_thoais.camera_truoc_id')
            ->join('he_dieu_hanh_cpus', 'he_dieu_hanh_cpus.id', '=', 'chi_tiet_dien_thoais.he_dieu_hanh_cpu_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('ket_nois', 'ket_nois.id', '=', 'chi_tiet_dien_thoais.ket_noi_id')
            ->join('pin_sacs', 'pin_sacs.id', '=', 'chi_tiet_dien_thoais.pin_sac_id')
            ->join('tien_iches', 'tien_iches.id', '=', 'chi_tiet_dien_thoais.tien_ich_id')
            ->join('thong_tin_chungs', 'thong_tin_chungs.id', '=', 'chi_tiet_dien_thoais.thong_tin_chung_id')
            ->where('chi_tiet_dien_thoais.dien_thoai_id', '=', $dienThoai->id)
            ->select(
                'man_hinhs.cong_nghe_man_hinh',
                'man_hinhs.do_phan_giai',
                'man_hinhs.man_hinh_rong',
                'man_hinhs.do_sang_toi_da',
                'man_hinhs.mat_kinh_cam_ung',
                'camera_saus.do_phan_giai as sau_phan_giai',
                'camera_saus.quay_phim',
                'camera_saus.den_flash',
                'camera_saus.tinh_nang as sau_tinh_nang',
                'camera_truocs.do_phan_giai as truoc_phan_giai',
                'camera_truocs.tinh_nang as truoc_tinh_nang',
                'he_dieu_hanh_cpus.he_dieu_hanh',
                'he_dieu_hanh_cpus.chip_xu_ly',
                'he_dieu_hanh_cpus.toc_do_cpu',
                'he_dieu_hanh_cpus.chip_do_hoa',
                'bo_nho_luu_trus.ram',
                'bo_nho_luu_trus.bo_nho_trong',
                'bo_nho_luu_trus.bo_nho_con_lai',
                'bo_nho_luu_trus.the_nho',
                'bo_nho_luu_trus.danh_ba',
                'ket_nois.mang_di_dong',
                'ket_nois.sim',
                'ket_nois.wifi',
                'ket_nois.gps',
                'ket_nois.bluetooth',
                'ket_nois.cong_ket_noi',
                'ket_nois.jack_tai_nghe',
                'ket_nois.ket_noi_khac',
                'pin_sacs.dung_luong_pin',
                'pin_sacs.loai_pin',
                'pin_sacs.ho_tro_sac_toi_da',
                'pin_sacs.sac_kem_theo_may',
                'pin_sacs.cong_nghe_pin',
                'tien_iches.bao_mat_nang_cao',
                'tien_iches.tinh_nang_dac_biet',
                'tien_iches.khang_nuoc_bui',
                'tien_iches.ghi_am',
                'tien_iches.xem_phim',
                'tien_iches.nghe_nhac',
                'thong_tin_chungs.thiet_ke',
                'thong_tin_chungs.chat_lieu',
                'thong_tin_chungs.kich_thuoc_khoi_luong',
                'thong_tin_chungs.thoi_diem_ra_mat'
            )
            ->first();
        $thongSoKyThuat->thoi_diem_ra_mat = Carbon::createFromFormat('Y-m-d', $thongSoKyThuat->thoi_diem_ra_mat)->format('d/m/Y');

        $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
            ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
            ->where('danh_gias.dien_thoai_id', '=', $dienThoai->id)
            ->where('danh_gias.trang_thai', '=', 1)
            ->select('danh_gias.*', 'tai_khoans.username')
            ->get();
        $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
            ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
            ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
            ->get();


        $motsao = 0;
        $haisao = 0;
        $basao = 0;
        $bonsao = 0;
        $namsao = 0;
        $soSaoTrungBinh = 0;

        if (count($danhSachDanhGia) > 0) {
            $temp = 0;
            foreach ($danhSachDanhGia as $tp) {
                if ($tp->so_sao == 5) {
                    $namsao++;
                } else if ($tp->so_sao == 4) {
                    $bonsao++;
                } else if ($tp->so_sao == 3) {
                    $basao++;
                } else if ($tp->so_sao == 2) {
                    $haisao++;
                } else if ($tp->so_sao == 1) {
                    $motsao++;
                }
                $temp += $tp->so_sao;
            }
            $motsao = $motsao / count($danhSachDanhGia) * 100;
            $haisao = $haisao / count($danhSachDanhGia) * 100;
            $basao = $basao / count($danhSachDanhGia) * 100;
            $bonsao = $bonsao / count($danhSachDanhGia) * 100;
            $namsao = $namsao / count($danhSachDanhGia) * 100;
            $soSaoTrungBinh = $temp / count($danhSachDanhGia);
        }

        $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
        FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
        WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
        AND dien_thoais.id != '.$dienThoai->id.'
        GROUP BY dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh');

        foreach ($danhSachDienThoai as $tp) {
            $tp->gia = ChiTietDienThoai::where('dien_thoai_id', '=', $tp->id)->min('gia');
            $khuyenMai = ChiTietKhuyenMai::where('dien_thoai_id', '=', $tp->id)->first();
            if (!empty($khuyenMai)) {
                $thoiGianKhuyenMai = KhuyenMai::where('id', '=', $khuyenMai->khuyen_mai_id)->first();
                if (strtotime($thoiGianKhuyenMai->ngay_ket_thuc) >= strtotime(date("Y-m-d"))) {
                    $tp->phan_tram_giam = $khuyenMai->phan_tram_giam;
                } else {
                    $tp->phan_tram_giam = 0;
                }
            } else {
                $tp->phan_tram_giam = 0;
            }
            $danhSachDanhGiaSP = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
            if (count($danhSachDanhGiaSP) > 0) {
                $temp = 0;
                foreach ($danhSachDanhGiaSP as $dg) {
                    $temp += $dg->so_sao;
                }
                $tp->so_sao_trung_binh = $temp / count($danhSachDanhGiaSP);
            } else {
                $tp->so_sao_trung_binh = 0;
            }
            $tp->so_luot_danh_gia = count($danhSachDanhGiaSP);
        }

        return view('user/product-detail', [
            'danhSachHinhAnhNoiBat' => $danhSachHinhAnhNoiBat, 'danhSachHinhAnh360' => $danhSachHinhAnh360,
            'hinhAnhMauSacSanPhamDaiDien' => $hinhAnhMauSacSanPhamDaiDien, 'hinhAnhMoHop' => $hinhAnhMoHop,
            'danhSachHinhAnhMauSac' => $danhSachHinhAnhMauSac, 'dienThoai' => $dienThoai,
            'thongSoKyThuat' => $thongSoKyThuat, 'danhSachChiTiet' => $danhSachChiTiet,
            'hinhAnhThongSoKyThuat' => $hinhAnhThongSoKyThuat, 'danhSachDanhGia' => $danhSachDanhGia,
            'soSaoTrungBinh' => $soSaoTrungBinh, 'motsao' => $motsao, 'haisao' => $haisao, 'basao' => $basao,
            'bonsao' => $bonsao, 'namsao' => $namsao, 'danhSachPhanHoi' => $danhSachPhanHoi,
            'danhSachDienThoai' => $danhSachDienThoai
        ]);
    }

    public function layGia(Request $request)
    {
        $output = '';
        $chiTietDienThoai = ChiTietDienThoai::where('id', '=', $request->idChiTiet)->first();
        $khuyenMai = ChiTietKhuyenMai::where('dien_thoai_id', '=', $chiTietDienThoai->dien_thoai_id)->first();
        if (!empty($khuyenMai)) {
            $thoiGianKhuyenMai = KhuyenMai::where('id', '=', $khuyenMai->khuyen_mai_id)->first();
            if (strtotime($thoiGianKhuyenMai->ngay_ket_thuc) >= strtotime(date("Y-m-d"))) {
                $chiTietDienThoai->phan_tram_giam = $khuyenMai->phan_tram_giam;
            } else {
                $chiTietDienThoai->phan_tram_giam = 0;
            }
        } else {
            $chiTietDienThoai->phan_tram_giam = 0;
        }
        if ($chiTietDienThoai->phan_tram_giam == 0) {
            $output .= '<strong class="price" style="font-size: 20px">Giá:
            ' . number_format($chiTietDienThoai->gia, 0, ',', '.') . '₫</strong>';
        } else {
            $output .= '<div class="box-p">
            <p class="price-old black" style="text-decoration: none;">Giá chưa giảm:
            ' . number_format($chiTietDienThoai->gia, 0, ',', '.') . '₫</p>
            <span
                class="percent">-' . $chiTietDienThoai->phan_tram_giam * 100 . '%</span>
        </div>
        <strong class="price" style="font-size: 20px; color:red">Giá giảm:
        ' . number_format($chiTietDienThoai->gia - $chiTietDienThoai->gia * $chiTietDienThoai->phan_tram_giam, 0, ',', '.') . '₫
        </strong>';
        }
        return response()->json($output);
    }
}
