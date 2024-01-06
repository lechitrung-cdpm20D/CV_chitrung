<?php

namespace App\Http\Controllers;

use App\Models\DienThoai;
use App\Models\KhuyenMai;
use App\Models\TaiKhoan;
use App\Models\DonHang;
use App\Models\CuaHang;
use App\Models\ChiTietDienThoai;
use App\Models\ChiTietKhuyenMai;
use App\Models\HinhAnhChungCuaDienThoai;
use App\Models\ThuongHieu;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DanhGia;
use Maatwebsite\Excel\Facades\Excel as Excel;
use App\Exports\DoanhThuExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Feedback;

class TrangChuController extends Controller
{
    public function index()
    {
        $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
        FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
        WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
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
            $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
            if (count($danhSachDanhGia) > 0) {
                $temp = 0;
                foreach ($danhSachDanhGia as $dg) {
                    $temp += $dg->so_sao;
                }
                $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
            } else {
                $tp->so_sao_trung_binh = 0;
            }
            $tp->so_luot_danh_gia = count($danhSachDanhGia);
        }

        //Danh sách điện thoại khuyến mãi
        $danhSachDienThoaiKM = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
        FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais, chi_tiet_khuyen_mais
        WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
        AND chi_tiet_khuyen_mais.dien_thoai_id = dien_thoais.id
        GROUP BY dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh');

        foreach ($danhSachDienThoaiKM as $tp) {
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
            $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
            if (count($danhSachDanhGia) > 0) {
                $temp = 0;
                foreach ($danhSachDanhGia as $dg) {
                    $temp += $dg->so_sao;
                }
                $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
            } else {
                $tp->so_sao_trung_binh = 0;
            }
            $tp->so_luot_danh_gia = count($danhSachDanhGia);
        }
        return view('user/index', ['danhSachDienThoai' => $danhSachDienThoai, 'danhSachDienThoaiKM' => $danhSachDienThoaiKM]);
    }

    public function filterProduct(Request $request)
    {
        $output = '';
        if ($request->idBrand == 0) {
            $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
            FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
            WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
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
                $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
                if (count($danhSachDanhGia) > 0) {
                    $temp = 0;
                    foreach ($danhSachDanhGia as $dg) {
                        $temp += $dg->so_sao;
                    }
                    $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
                } else {
                    $tp->so_sao_trung_binh = 0;
                }
                $tp->so_luot_danh_gia = count($danhSachDanhGia);
            }

            foreach ($danhSachDienThoai as $tp) {
                $output .= '<li class="item">
                    <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                        <div class="item-label">
                            <span class="lb-tragop">Trả góp 0%</span>
                        </div>
                        <div class="item-img item-img_42">
                            <img class="thumb ls-is-cached lazyloaded" alt=""
                                src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                        </div>
                        <h3>
                        ' . $tp->ten_san_pham . '
                        </h3>
                        ';
                if ($tp->phan_tram_giam == 0) {
                    $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
                } else {
                    $output .= '<div class="box-p">
                            <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                            <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                        </div>
                        <strong
                            class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                        </strong>';
                }
                $output .= '<div class="item-rating">';
                if ($tp->so_sao_trung_binh > 4.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 3.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 2.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 1.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 0.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } else {
                    $output .= ' <p>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                }
                $output .= ' <p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                    </div>
                </a>
                <div class="item-bottom">
                    <a href="#" class="shiping"></a>
                </div>
            </li>';
            }
            return response()->json($output);
        } else {
            $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
            FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
            WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
            AND dien_thoais.thuong_hieu_id = ' . $request->idBrand . '
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
                $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
                if (count($danhSachDanhGia) > 0) {
                    $temp = 0;
                    foreach ($danhSachDanhGia as $dg) {
                        $temp += $dg->so_sao;
                    }
                    $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
                } else {
                    $tp->so_sao_trung_binh = 0;
                }
                $tp->so_luot_danh_gia = count($danhSachDanhGia);
            }

            foreach ($danhSachDienThoai as $tp) {
                $output .= '<li class="item">
                    <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                        <div class="item-label">
                            <span class="lb-tragop">Trả góp 0%</span>
                        </div>
                        <div class="item-img item-img_42">
                            <img class="thumb ls-is-cached lazyloaded" alt=""
                                src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                        </div>
                        <h3>
                        ' . $tp->ten_san_pham . '
                        </h3>
                        ';
                if ($tp->phan_tram_giam == 0) {
                    $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
                } else {
                    $output .= '<div class="box-p">
                            <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                            <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                        </div>
                        <strong
                            class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                        </strong>';
                }
                $output .= '<div class="item-rating">';
                if ($tp->so_sao_trung_binh > 4.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 3.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 2.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 1.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 0.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } else {
                    $output .= ' <p>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                }
                $output .= '<p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                    </div>
                </a>
                <div class="item-bottom">
                    <a href="#" class="shiping"></a>
                </div>
            </li>';
            }
            return response()->json($output);
        }
    }

    public function filterProductByPrice(Request $request)
    {
        $output = '';
        if ($request->idBrand == 0) {
            $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
            FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
            WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
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
                $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
                if (count($danhSachDanhGia) > 0) {
                    $temp = 0;
                    foreach ($danhSachDanhGia as $dg) {
                        $temp += $dg->so_sao;
                    }
                    $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
                } else {
                    $tp->so_sao_trung_binh = 0;
                }
                $tp->so_luot_danh_gia = count($danhSachDanhGia);
            }

            if ($request->type == 1) {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($danhSachDienThoai);
                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử lớn nhất
                    $max = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($danhSachDienThoai[$j]->gia > $danhSachDienThoai[$max]->gia) {
                            $max = $j;
                        }
                    }
                    // Sau khi có vị trí lớn nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $danhSachDienThoai[$i];
                    $danhSachDienThoai[$i] = $danhSachDienThoai[$max];
                    $danhSachDienThoai[$max] = $temp;
                }
            } else if ($request->type == 2) {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($danhSachDienThoai);
                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử lớn nhất
                    $max = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($danhSachDienThoai[$j]->phan_tram_giam > $danhSachDienThoai[$max]->phan_tram_giam) {
                            $max = $j;
                        }
                    }
                    // Sau khi có vị trí lớn nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $danhSachDienThoai[$i];
                    $danhSachDienThoai[$i] = $danhSachDienThoai[$max];
                    $danhSachDienThoai[$max] = $temp;
                }
            } else {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($danhSachDienThoai);

                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử nhỏ nhất
                    $min = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($danhSachDienThoai[$j]->gia < $danhSachDienThoai[$min]->gia) {
                            $min = $j;
                        }
                    }

                    // Sau khi có vị trí nhỏ nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $danhSachDienThoai[$i];
                    $danhSachDienThoai[$i] = $danhSachDienThoai[$min];
                    $danhSachDienThoai[$min] = $temp;
                }
            }
            foreach ($danhSachDienThoai as $tp) {
                $output .= '<li class="item">
                        <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                            <div class="item-label">
                                <span class="lb-tragop">Trả góp 0%</span>
                            </div>
                            <div class="item-img item-img_42">
                                <img class="thumb ls-is-cached lazyloaded" alt=""
                                    src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                            </div>
                            <h3>
                            ' . $tp->ten_san_pham . '
                            </h3>
                            ';
                if ($tp->phan_tram_giam == 0) {
                    $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
                } else {
                    $output .= '<div class="box-p">
                                <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                                <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                            </div>
                            <strong
                                class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                            </strong>';
                }
                $output .= '<div class="item-rating">';
                if ($tp->so_sao_trung_binh > 4.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 3.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 2.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 1.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } elseif ($tp->so_sao_trung_binh > 0.5) {
                    $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                } else {
                    $output .= ' <p>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
                }
                $output .= '<p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                        </div>
                    </a>
                    <div class="item-bottom">
                        <a href="#" class="shiping"></a>
                    </div>
                </li>';
            }
            return response()->json($output);
        } else {
            $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
            FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
            WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
            AND dien_thoais.thuong_hieu_id = ' . $request->idBrand . '
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
                $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
                if (count($danhSachDanhGia) > 0) {
                    $temp = 0;
                    foreach ($danhSachDanhGia as $dg) {
                        $temp += $dg->so_sao;
                    }
                    $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
                } else {
                    $tp->so_sao_trung_binh = 0;
                }
                $tp->so_luot_danh_gia = count($danhSachDanhGia);
            }
            if ($request->type == 1) {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($danhSachDienThoai);
                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử lớn nhất
                    $max = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($danhSachDienThoai[$j]->gia > $danhSachDienThoai[$max]->gia) {
                            $max = $j;
                        }
                    }
                    // Sau khi có vị trí lớn nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $danhSachDienThoai[$i];
                    $danhSachDienThoai[$i] = $danhSachDienThoai[$max];
                    $danhSachDienThoai[$max] = $temp;
                }
                foreach ($danhSachDienThoai as $tp) {
                    $output .= '<li class="item">
                        <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                            <div class="item-label">
                                <span class="lb-tragop">Trả góp 0%</span>
                            </div>
                            <div class="item-img item-img_42">
                                <img class="thumb ls-is-cached lazyloaded" alt=""
                                    src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                            </div>
                            <h3>
                            ' . $tp->ten_san_pham . '
                            </h3>
                            ';
                    if ($tp->phan_tram_giam == 0) {
                        $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
                    } else {
                        $output .= '<div class="box-p">
                                <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                                <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                            </div>
                            <strong
                                class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                            </strong>';
                    }
                    $output .= '<div class="item-rating">';
                    if ($tp->so_sao_trung_binh > 4.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 3.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 2.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 1.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 0.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } else {
                        $output .= ' <p>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    }
                    $output .= '<p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                        </div>
                    </a>
                    <div class="item-bottom">
                        <a href="#" class="shiping"></a>
                    </div>
                </li>';
                }
                return response()->json($output);
            } else if ($request->type == 2) {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($danhSachDienThoai);
                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử lớn nhất
                    $max = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($danhSachDienThoai[$j]->phan_tram_giam > $danhSachDienThoai[$max]->phan_tram_giam) {
                            $max = $j;
                        }
                    }
                    // Sau khi có vị trí lớn nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $danhSachDienThoai[$i];
                    $danhSachDienThoai[$i] = $danhSachDienThoai[$max];
                    $danhSachDienThoai[$max] = $temp;
                }
                foreach ($danhSachDienThoai as $tp) {
                    $output .= '<li class="item">
                        <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                            <div class="item-label">
                                <span class="lb-tragop">Trả góp 0%</span>
                            </div>
                            <div class="item-img item-img_42">
                                <img class="thumb ls-is-cached lazyloaded" alt=""
                                    src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                            </div>
                            <h3>
                            ' . $tp->ten_san_pham . '
                            </h3>
                            ';
                    if ($tp->phan_tram_giam == 0) {
                        $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
                    } else {
                        $output .= '<div class="box-p">
                                <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                                <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                            </div>
                            <strong
                                class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                            </strong>';
                    }
                    $output .= '<div class="item-rating">';
                    if ($tp->so_sao_trung_binh > 4.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 3.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 2.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 1.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 0.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } else {
                        $output .= ' <p>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    }
                    $output .= '<p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                        </div>
                    </a>
                    <div class="item-bottom">
                        <a href="#" class="shiping"></a>
                    </div>
                </li>';
                }
                return response()->json($output);
            } else {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($danhSachDienThoai);

                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử nhỏ nhất
                    $min = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($danhSachDienThoai[$j]->gia < $danhSachDienThoai[$min]->gia) {
                            $min = $j;
                        }
                    }

                    // Sau khi có vị trí nhỏ nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $danhSachDienThoai[$i];
                    $danhSachDienThoai[$i] = $danhSachDienThoai[$min];
                    $danhSachDienThoai[$min] = $temp;
                }
                foreach ($danhSachDienThoai as $tp) {
                    $output .= '<li class="item">
                        <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                            <div class="item-label">
                                <span class="lb-tragop">Trả góp 0%</span>
                            </div>
                            <div class="item-img item-img_42">
                                <img class="thumb ls-is-cached lazyloaded" alt=""
                                    src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                            </div>
                            <h3>
                            ' . $tp->ten_san_pham . '
                            </h3>
                            ';
                    if ($tp->phan_tram_giam == 0) {
                        $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
                    } else {
                        $output .= '<div class="box-p">
                                <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                                <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                            </div>
                            <strong
                                class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                            </strong>';
                    }
                    $output .= '<div class="item-rating">';
                    if ($tp->so_sao_trung_binh > 4.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 3.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 2.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 1.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } elseif ($tp->so_sao_trung_binh > 0.5) {
                        $output .= ' <p>
                                <i class="icon-star"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    } else {
                        $output .= ' <p>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                                <i class="icon-star-dark"></i>
                            </p>';
                    }
                    $output .= '<p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                        </div>
                    </a>
                    <div class="item-bottom">
                        <a href="#" class="shiping"></a>
                    </div>
                </li>';
                }
                return response()->json($output);
            }
        }
    }

    public function suggestSearch(Request $request)
    {
        $output = '';
        $timKiem = DienThoai::where('ten_san_pham', 'like', '%' . $request->search . '%')->get();
        if (count($timKiem) > 0) {
            $output .= '<li class="ttitle">
            <div class="viewed">Có phải bạn muốn tìm</div>
            </li>';
            foreach ($timKiem as $tp) {
                $output .= '<li data-text="true"><a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">' . $tp->ten_san_pham . '</a>';
            }
            return response()->json($output);
        }
        $output .= '<li class="ttitle">
        <div class="viewed">Không có kết quả trùng với từ khóa tìm kiếm !</div>
        </li>';
        return response()->json($output);
    }

    public function resultSearch(Request $request)
    {
        $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
        FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
        WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
        AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
        AND dien_thoais.ten_san_pham LIKE "%' . $request->search . '%"
        GROUP BY dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh');

        if (count($danhSachDienThoai) > 0) {
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
                $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
                if (count($danhSachDanhGia) > 0) {
                    $temp = 0;
                    foreach ($danhSachDanhGia as $dg) {
                        $temp += $dg->so_sao;
                    }
                    $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
                } else {
                    $tp->so_sao_trung_binh = 0;
                }
                $tp->so_luot_danh_gia = count($danhSachDanhGia);
            }
        }

        return view('user/result-search', ['danhSachDienThoai' => $danhSachDienThoai, 'search' => $request->search]);
    }

    public function filterProductByPriceResultSearch(Request $request)
    {
        $output = '';

        $danhSachDienThoai = DB::select('SELECT dien_thoais.id, dien_thoais.ten_san_pham, hinh_anh_chung_cua_dien_thoais.hinh_anh
            FROM dien_thoais, chi_tiet_dien_thoais, hinh_anh_chung_cua_dien_thoais
            WHERE chi_tiet_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.dien_thoai_id = dien_thoais.id
            AND hinh_anh_chung_cua_dien_thoais.loai_hinh = 0
            AND dien_thoais.ten_san_pham LIKE "%' . $request->search . '%"
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
            $danhSachDanhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)->where('danh_gias.trang_thai', '=', 1)->get();
            if (count($danhSachDanhGia) > 0) {
                $temp = 0;
                foreach ($danhSachDanhGia as $dg) {
                    $temp += $dg->so_sao;
                }
                $tp->so_sao_trung_binh = $temp / count($danhSachDanhGia);
            } else {
                $tp->so_sao_trung_binh = 0;
            }
            $tp->so_luot_danh_gia = count($danhSachDanhGia);
        }

        if ($request->type == 1) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($danhSachDienThoai);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($danhSachDienThoai[$j]->gia > $danhSachDienThoai[$max]->gia) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $danhSachDienThoai[$i];
                $danhSachDienThoai[$i] = $danhSachDienThoai[$max];
                $danhSachDienThoai[$max] = $temp;
            }
        } else if ($request->type == 2) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($danhSachDienThoai);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($danhSachDienThoai[$j]->phan_tram_giam > $danhSachDienThoai[$max]->phan_tram_giam) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $danhSachDienThoai[$i];
                $danhSachDienThoai[$i] = $danhSachDienThoai[$max];
                $danhSachDienThoai[$max] = $temp;
            }
        } else {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($danhSachDienThoai);

            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử nhỏ nhất
                $min = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($danhSachDienThoai[$j]->gia < $danhSachDienThoai[$min]->gia) {
                        $min = $j;
                    }
                }

                // Sau khi có vị trí nhỏ nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $danhSachDienThoai[$i];
                $danhSachDienThoai[$i] = $danhSachDienThoai[$min];
                $danhSachDienThoai[$min] = $temp;
            }
        }
        foreach ($danhSachDienThoai as $tp) {
            $output .= '<li class="item">
                        <a href="' . route('productDetail', ['sanPhamId' => $tp->id]) . '">
                            <div class="item-label">
                                <span class="lb-tragop">Trả góp 0%</span>
                            </div>
                            <div class="item-img item-img_42">
                                <img class="thumb ls-is-cached lazyloaded" alt=""
                                    src=" ' . asset("storage/images/$tp->hinh_anh") . ' ">
                            </div>
                            <h3>
                            ' . $tp->ten_san_pham . '
                            </h3>
                            ';
            if ($tp->phan_tram_giam == 0) {
                $output .= '<strong class="price"> ' . number_format($tp->gia, 0, ',', '.') . '₫</strong>';
            } else {
                $output .= '<div class="box-p">
                                <p class="price-old black">' . number_format($tp->gia, 0, ',', '.') . '₫</p>
                                <span class="percent">-' . $tp->phan_tram_giam * 100 . '%</span>
                            </div>
                            <strong
                                class="price">' . number_format($tp->gia - $tp->gia * $tp->phan_tram_giam, 0, ',', '.') . '₫
                            </strong>';
            }
            $output .= '<div class="item-rating">';
            if ($tp->so_sao_trung_binh > 4.5) {
                $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                        </p>';
            } elseif ($tp->so_sao_trung_binh > 3.5) {
                $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
            } elseif ($tp->so_sao_trung_binh > 2.5) {
                $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
            } elseif ($tp->so_sao_trung_binh > 1.5) {
                $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
            } elseif ($tp->so_sao_trung_binh > 0.5) {
                $output .= ' <p>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
            } else {
                $output .= ' <p>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                        </p>';
            }
            $output .= '<p class="item-rating-total">' . $tp->so_luot_danh_gia . '</p>
                        </div>
                    </a>
                    <div class="item-bottom">
                        <a href="#" class="shiping"></a>
                    </div>
                </li>';
        }
        return response()->json($output);
    }

    public function indexAdmin()
    {
        // $danhSachKhachHang = TaiKhoan::where('loai_tai_khoan_id', '>', 4)->get();
        // $danhSachDonHang = DonHang::all();
        // $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
        // $danhSachSanPham = DienThoai::where('trang_thai', '=', 1)->get();
        // $tongSoND = count($danhSachKhachHang);
        // $tongSoDH = count($danhSachDonHang);
        // $tongSoCH = count($danhSachCuaHang);
        // $tongSoSP = count($danhSachSanPham);
        $doanhThuTungThang = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
            ->where('don_hangs.trang_thai_don_hang', '=', 3)
            ->whereYear('don_hangs.ngay_tao', '=', now()->year)
            ->select(DB::raw("MONTH(don_hangs.ngay_tao) thang"), DB::raw('sum(chi_tiet_don_hangs.gia_giam * chi_tiet_don_hangs.so_luong) doanhthu'))
            ->groupBy('thang')
            ->get();
        $doanhThuTungNam = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
            ->where('don_hangs.trang_thai_don_hang', '=', 3)
            ->select(DB::raw("YEAR(don_hangs.ngay_tao) nam"), DB::raw('sum(chi_tiet_don_hangs.gia_giam * chi_tiet_don_hangs.so_luong) doanhthu'))
            ->groupBy('nam')
            ->orderBy('nam', 'DESC')
            ->limit('5')
            ->get();
        $nam = date('Y');
        $tongSoLuongBanRa = 0;
        $danhSachThuongHieu = ThuongHieu::all();
        $danhSachThuongHieuXoa = ThuongHieu::onlyTrashed()->get();
        for($i = 0;$i<count($danhSachThuongHieuXoa);$i++){
            $danhSachThuongHieu[count($danhSachThuongHieu)+$i] = $danhSachThuongHieuXoa[$i];
        }
        // dd($danhSachThuongHieu);
        foreach ($danhSachThuongHieu as $tp) {
            $soLuong = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
                ->join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_don_hangs.chi_tiet_dien_thoai_id')
                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                ->where('dien_thoais.thuong_hieu_id', '=', $tp->id)
                ->where('don_hangs.trang_thai_don_hang', '=', 3)
                ->whereYear('don_hangs.ngay_tao', '=', now()->year)
                ->select(DB::raw('sum(chi_tiet_don_hangs.so_luong) soluong'))
                ->get();
            $tp->sl_sp_ban_ra = $soLuong[0]->soluong;
            $tongSoLuongBanRa = $tongSoLuongBanRa + $tp->sl_sp_ban_ra;
        }
        foreach ($danhSachThuongHieu as $tp) {
            $tp->phan_tram = $tp->sl_sp_ban_ra / $tongSoLuongBanRa * 100;
        }
        return view('admin/index', [
            // 'tongSoND' => $tongSoND, 'tongSoDH' => $tongSoDH,
            // 'tongSoCH' => $tongSoCH, 'tongSoSP' => $tongSoSP,
            'doanhThuTungThang' => $doanhThuTungThang,
            'doanhThuTungNam' => $doanhThuTungNam,
            'danhSachThuongHieu' => $danhSachThuongHieu,
            'nam' => $nam,
        ]);
    }

    public function layDoanhThu(Request $request)
    {
        // $danhSachKhachHang = TaiKhoan::where('loai_tai_khoan_id', '>', 4)->get();
        // $danhSachDonHang = DonHang::all();
        // $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
        // $danhSachSanPham = DienThoai::where('trang_thai', '=', 1)->get();
        // $tongSoND = count($danhSachKhachHang);
        // $tongSoDH = count($danhSachDonHang);
        // $tongSoCH = count($danhSachCuaHang);
        // $tongSoSP = count($danhSachSanPham);
        $doanhThuTungThang = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
            ->where('don_hangs.trang_thai_don_hang', '=', 3)
            ->whereYear('don_hangs.ngay_tao', '=', $request->input('nam'))
            ->select(DB::raw("MONTH(don_hangs.ngay_tao) thang"), DB::raw('sum(chi_tiet_don_hangs.gia_giam * chi_tiet_don_hangs.so_luong) doanhthu'))
            ->groupBy('thang')
            ->get();
        $doanhThuTungNam = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
            ->where('don_hangs.trang_thai_don_hang', '=', 3)
            ->select(DB::raw("YEAR(don_hangs.ngay_tao) nam"), DB::raw('sum(chi_tiet_don_hangs.gia_giam * chi_tiet_don_hangs.so_luong) doanhthu'))
            ->groupBy('nam')
            ->orderBy('nam', 'DESC')
            ->limit('5')
            ->get();
        $nam = $request->input('nam');
        $tongSoLuongBanRa = 0;
        $danhSachThuongHieu = ThuongHieu::all();
        $danhSachThuongHieuXoa = ThuongHieu::onlyTrashed()->get();
        for($i = 0;$i<count($danhSachThuongHieuXoa);$i++){
            $danhSachThuongHieu[count($danhSachThuongHieu)+$i] = $danhSachThuongHieuXoa[$i];
        }
        foreach ($danhSachThuongHieu as $tp) {
            $soLuong = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
                ->join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_don_hangs.chi_tiet_dien_thoai_id')
                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                ->where('dien_thoais.thuong_hieu_id', '=', $tp->id)
                ->where('don_hangs.trang_thai_don_hang', '=', 3)
                ->whereYear('don_hangs.ngay_tao', '=', $request->input('nam'))
                ->select(DB::raw('sum(chi_tiet_don_hangs.so_luong) soluong'))
                ->get();
            $tp->sl_sp_ban_ra = $soLuong[0]->soluong;
            $tongSoLuongBanRa = $tongSoLuongBanRa + $tp->sl_sp_ban_ra;
        }
        foreach ($danhSachThuongHieu as $tp) {
            $tp->phan_tram = $tp->sl_sp_ban_ra / $tongSoLuongBanRa * 100;
        }
        return view('admin/index', [
            // 'tongSoND' => $tongSoND, 'tongSoDH' => $tongSoDH,
            // 'tongSoCH' => $tongSoCH, 'tongSoSP' => $tongSoSP,
            'doanhThuTungThang' => $doanhThuTungThang,
            'doanhThuTungNam' => $doanhThuTungNam,
            'danhSachThuongHieu' => $danhSachThuongHieu,
            'nam' => $nam,
        ]);
    }

    public function export_csv(Request $request)
    {
        return Excel::download(new DoanhThuExport($request->input('doanh_thu_nam')), 'doanh_thu_' . $request->input('doanh_thu_nam') . '.xlsx');
    }

    public function lienHe(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'topicFilter' => 'required',
                'fullname' => 'required|max:30',
                'title' => 'required|max:30',
                'phone' => 'required|regex:/(09)[0-9]{8}/',
                'message' => 'required|max:300',
                'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute vượt quá số ký tự cho phép !',
                'regex' => ':attribute không hợp lệ ! Vui lòng kiểm tra lại !',
            ],
            [
                'topicFilter' => 'Topic',
                'fullname' => 'Họ tên',
                'title' => 'Tiêu đề',
                'phone' => 'Số điện thoại',
                'message' => 'Nội dung',
                'email' => 'Email',
            ]
        );

        if ($validated->fails()) {
            $errors = $validated->getMessageBag();
            $msg = '';
            foreach ($errors->all() as $tp) {
                $msg .= $tp . ' ';
            }
            return response()->json(
                $msg,
                404,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
        }
        $details = [
            'topicFilter' => $request->topicFilter,
            'fullname' => $request->fullname,
            'title' => $request->title,
            'phone' => $request->phone,
            'message' => $request->message,
            'email' => $request->email,
        ];
        Mail::to('ttmobile1306@gmail.com')->send(new Feedback($details));
        return response()->json('ok');
    }
    public function gioithieu()
    {
        $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
        return view('user/introduce', ['danhSachCuaHang' => $danhSachCuaHang]);
    }
    public function timCuaHang()
    {
        $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
        return view('user/findstore', ['danhSachCuaHang' => $danhSachCuaHang]);
    }
}
