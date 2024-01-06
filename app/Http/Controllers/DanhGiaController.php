<?php

namespace App\Http\Controllers;

use App\Models\DienThoai;
use App\Models\DanhGia;
use App\Models\PhanHoiDanhGia;
use App\Models\HinhAnhChungCuaDienThoai;
use App\Models\TaiKhoan;
use App\Models\ChiTietDonHang;
use App\Models\ThongTinTaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class DanhGiaController extends Controller
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
     * @param  \App\Http\Requests\StoreDanhGiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function show(DanhGia $danhGia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function edit(DanhGia $danhGia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDanhGiaRequest  $request
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DanhGia $danhGia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function destroy(DanhGia $danhGia)
    {
        //
    }

    public function indexDanhGiaKH()
    {
        $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
        $danhSachSanPham = ChiTietDonHang::join('chi_tiet_dien_thoais', 'chi_tiet_dien_thoais.id', '=', 'chi_tiet_don_hangs.chi_tiet_dien_thoai_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->join('don_hangs', 'don_hangs.ma_don_hang', '=', 'chi_tiet_don_hangs.don_hang_id')
            ->where('don_hangs.trang_thai_don_hang', '=', 3)
            ->where('don_hangs.tai_khoan_khach_hang_id','=',Auth::user()->id)
            ->select('dien_thoais.id', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->groupBy('dien_thoais.id', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        foreach ($danhSachSanPham as $tp) {
            $danhGia = DanhGia::where('dien_thoai_id', '=', $tp->id)
                ->where('tai_khoan_id', '=', Auth::user()->id)
                ->first();
            if (!empty($danhGia)) {
                $tp->noi_dung = $danhGia->noi_dung;
                $tp->so_sao = $danhGia->so_sao;
            } else {
                $tp->noi_dung = null;
                $tp->so_sao = 0;
            }
        }
        return view('user/review', ['thongTinTaiKhoan' => $thongTinTaiKhoan, 'danhSachSanPham' => $danhSachSanPham]);
    }

    public function storeDanhGia(Request $request)
    {
        $danhGia = new DanhGia();
        $danhGia->fill([
            'tai_khoan_id' => Auth::user()->id,
            'dien_thoai_id' => $request->input('dienthoaiid'),
            'noi_dung' => $request->input('noidung'),
            'so_sao' => $request->input('sosao'),
            'trang_thai' => 1,
        ]);
        if ($danhGia->save() == true) {
            return redirect()->back()->with('thongbao', 'Đánh giá sản phẩm thành công ! Cảm ơn quý khách !');
        }
        return redirect()->back()->with('thongbao', 'Đánh giá sản phẩm không thành công !');
    }

    public function indexDanhGiaAdmin($dienThoaiId)
    {
        $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
            ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
            ->where('danh_gias.dien_thoai_id', '=', $dienThoaiId)
            ->select('danh_gias.*', 'tai_khoans.username', 'dien_thoais.ten_san_pham')
            ->get();
        return view('admin/management-page/review', ['danhSachDanhGia' => $danhSachDanhGia]);
    }

    public function thayDoiTrangThaiDanhGia($danhGiaId)
    {
        $danhGia = DanhGia::where('id', '=', $danhGiaId)->first();
        if ($danhGia->trang_thai == 1) {
            $danhGia->fill([
                'trang_thai' => 0,
            ]);
            if ($danhGia->save() == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đánh giá thành công!');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đánh giá không thành công!');
        }
        $danhGia->fill([
            'trang_thai' => 1,
        ]);
        if ($danhGia->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đánh giá thành công!');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật trạng thái đánh giá không thành công!');
    }

    public function listDanhGiaKH($dienThoaiId)
    {
        $dienThoai = DienThoai::where('id', '=', $dienThoaiId)->first();
        $hinhAnhDaiDien = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $dienThoaiId)
            ->where('loai_hinh', '=', 0)
            ->first();
        $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
            ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
            ->where('danh_gias.dien_thoai_id', '=', $dienThoaiId)
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
        return view('user/review-list', [
            'danhSachDanhGia' => $danhSachDanhGia,
            'soSaoTrungBinh' => $soSaoTrungBinh, 'motsao' => $motsao, 'haisao' => $haisao, 'basao' => $basao,
            'bonsao' => $bonsao, 'namsao' => $namsao, 'danhSachPhanHoi' => $danhSachPhanHoi,
            'dienThoai' => $dienThoai, 'hinhAnhDaiDien' => $hinhAnhDaiDien
        ]);
    }

    public function filterReview(Request $request)
    {
        $output = '';

        if ($request->sosao == 0) {
            $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
                ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
                ->where('danh_gias.dien_thoai_id', '=', $request->dienThoaiId)
                ->where('danh_gias.trang_thai', '=', 1)
                ->select('danh_gias.*', 'tai_khoans.username')
                ->get();

            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
                ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();

            foreach ($danhSachDanhGia as $tp) {
                $output .= '<div class="comment-item par">
                <div class="item-top">
                    <p class="txtname" style="text-transform:none;">' . $tp->username . '</p>
                </div>
                <div class="item-rate">
                    <div class="comment-star">';
                if ($tp->so_sao > 4.5) {
                    $output .= '<i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>';
                } elseif ($tp->so_sao > 3.5) {
                    $output .= '<i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 2.5) {
                    $output .= '<i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 1.5) {
                    $output .= '<i class="icon-star"></i>
                            <i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 0.5) {
                    $output .= '<i class="icon-star"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>';
                } else {
                    $output .= ' <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>
                            <i class="icon-star-dark"></i>';
                }
                $output .= '</div>
                </div>
                <div class="comment-content">
                    <p class="cmt-txt">' . $tp->noi_dung . '</p>
                </div>

                <div class="item-click">
                    <a href="javascript:showRatingCmtChild(' . '`' . $tp->username . '`' . ')" class="click-cmt">
                        <i class="icondetail-comment"></i>
                        <span class="cmtr">Thảo luận</span>
                    </a>
                    <div class="' . $tp->username . ' reply hide">
                        <input placeholder="Nhập thảo luận của bạn" style="color: #3e5569;"
                        name="noidung" id="noidung">
                        <input type="hidden" value="' . $tp->id . '" name="danhgiaid">
                        <a href="javascript:themPhanHoi();" class="rrSend">GỬI</a>
                    </div>
                </div>
            </div>
            <div class="phanhoi">';
                if (count($danhSachPhanHoi) > 0) {
                    foreach ($danhSachPhanHoi as $ph) {
                        if ($ph->danh_gia_id == $tp->id) {
                            $output .= '<div
                            class="comment-item ' . $tp->username . ' childC-item hide">
                            <div class="item-top">
                                <p class="txtname" style="text-transform:none">' . $ph->username . '</p>';
                            if ($ph->loai_tai_khoan_id < 5) {
                                $output .= '<span class="qtv">QTV</span>';
                            }
                            $output .= '</div>
                            <div class="item-rate">
                            </div>
                            <div class="comment-content">
                                <p class="cmt-txt">' . $ph->noi_dung . '</p>
                            </div>
                        </div>';
                        }
                    }
                }
                $output .= '</div>';
            }
        } elseif ($request->sosao == 1) {
            $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
                ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
                ->where('danh_gias.dien_thoai_id', '=', $request->dienThoaiId)
                ->where('danh_gias.so_sao', '=', 1)
                ->where('danh_gias.trang_thai', '=', 1)
                ->select('danh_gias.*', 'tai_khoans.username')
                ->get();
            if (count($danhSachDanhGia) == 0) {
                $output .= '
                        <p style="width: 450px;text-align:center"><img src=' . asset('assets/user/images/data-not-found.png') . ' width="150"></p>
                        <p style="width: 450px;text-align:center;font-weight: bold;">Không có đánh giá !</p>';
                return response()->json($output);
            }
            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
                ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();

            foreach ($danhSachDanhGia as $tp) {
                $output .= '<div class="comment-item par">
            <div class="item-top">
                <p class="txtname" style="text-transform:none;">' . $tp->username . '</p>
            </div>
            <div class="item-rate">
                <div class="comment-star">';
                if ($tp->so_sao > 4.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>';
                } elseif ($tp->so_sao > 3.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 2.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 1.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 0.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } else {
                    $output .= ' <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                }
                $output .= '</div>
            </div>
            <div class="comment-content">
                <p class="cmt-txt">' . $tp->noi_dung . '</p>
            </div>

            <div class="item-click">
                <a href="javascript:showRatingCmtChild(' . '`' . $tp->username . '`' . ')" class="click-cmt">
                    <i class="icondetail-comment"></i>
                    <span class="cmtr">Thảo luận</span>
                </a>
                <div class="' . $tp->username . ' reply hide">
                    <input placeholder="Nhập thảo luận của bạn" style="color: #3e5569;"
                    name="noidung" id="noidung">
                    <input type="hidden" value="' . $tp->id . '" name="danhgiaid">
                    <a href="javascript:themPhanHoi();" class="rrSend">GỬI</a>
                </div>
            </div>
        </div>
        <div class="phanhoi">';
                if (count($danhSachPhanHoi) > 0) {
                    foreach ($danhSachPhanHoi as $ph) {
                        if ($ph->danh_gia_id == $tp->id) {
                            $output .= '<div
                        class="comment-item ' . $tp->username . ' childC-item hide">
                        <div class="item-top">
                            <p class="txtname" style="text-transform:none">' . $ph->username . '</p>';
                            if ($ph->loai_tai_khoan_id < 5) {
                                $output .= '<span class="qtv">QTV</span>';
                            }
                            $output .= '</div>
                        <div class="item-rate">
                        </div>
                        <div class="comment-content">
                            <p class="cmt-txt">' . $ph->noi_dung . '</p>
                        </div>
                    </div>';
                        }
                    }
                }
                $output .= '</div>';
            }
        } elseif ($request->sosao == 2) {
            $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
                ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
                ->where('danh_gias.dien_thoai_id', '=', $request->dienThoaiId)
                ->where('danh_gias.so_sao', '=', 2)
                ->where('danh_gias.trang_thai', '=', 1)
                ->select('danh_gias.*', 'tai_khoans.username')
                ->get();
            if (count($danhSachDanhGia) == 0) {
                $output .= '
                    <p style="width: 450px;text-align:center"><img src=' . asset('assets/user/images/data-not-found.png') . ' width="150"></p>
                    <p style="width: 450px;text-align:center;font-weight: bold;">Không có đánh giá !</p>';
                return response()->json($output);
            }
            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
                ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();

            foreach ($danhSachDanhGia as $tp) {
                $output .= '<div class="comment-item par">
            <div class="item-top">
                <p class="txtname" style="text-transform:none;">' . $tp->username . '</p>
            </div>
            <div class="item-rate">
                <div class="comment-star">';
                if ($tp->so_sao > 4.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>';
                } elseif ($tp->so_sao > 3.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 2.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 1.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 0.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } else {
                    $output .= ' <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                }
                $output .= '</div>
            </div>
            <div class="comment-content">
                <p class="cmt-txt">' . $tp->noi_dung . '</p>
            </div>

            <div class="item-click">
                <a href="javascript:showRatingCmtChild(' . '`' . $tp->username . '`' . ')" class="click-cmt">
                    <i class="icondetail-comment"></i>
                    <span class="cmtr">Thảo luận</span>
                </a>
                <div class="' . $tp->username . ' reply hide">
                    <input placeholder="Nhập thảo luận của bạn" style="color: #3e5569;"
                    name="noidung" id="noidung">
                    <input type="hidden" value="' . $tp->id . '" name="danhgiaid">
                    <a href="javascript:themPhanHoi();" class="rrSend">GỬI</a>
                </div>
            </div>
        </div>
        <div class="phanhoi">';
                if (count($danhSachPhanHoi) > 0) {
                    foreach ($danhSachPhanHoi as $ph) {
                        if ($ph->danh_gia_id == $tp->id) {
                            $output .= '<div
                        class="comment-item ' . $tp->username . ' childC-item hide">
                        <div class="item-top">
                            <p class="txtname" style="text-transform:none">' . $ph->username . '</p>';
                            if ($ph->loai_tai_khoan_id < 5) {
                                $output .= '<span class="qtv">QTV</span>';
                            }
                            $output .= '</div>
                        <div class="item-rate">
                        </div>
                        <div class="comment-content">
                            <p class="cmt-txt">' . $ph->noi_dung . '</p>
                        </div>
                    </div>';
                        }
                    }
                }
                $output .= '</div>';
            }
        } elseif ($request->sosao == 3) {
            $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
                ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
                ->where('danh_gias.dien_thoai_id', '=', $request->dienThoaiId)
                ->where('danh_gias.so_sao', '=', 3)
                ->where('danh_gias.trang_thai', '=', 1)
                ->select('danh_gias.*', 'tai_khoans.username')
                ->get();
            if (count($danhSachDanhGia) == 0) {
                $output .= '
                        <p style="width: 450px;text-align:center"><img src=' . asset('assets/user/images/data-not-found.png') . ' width="150"></p>
                        <p style="width: 450px;text-align:center;font-weight: bold;">Không có đánh giá !</p>';
                return response()->json($output);
            }
            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
                ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();

            foreach ($danhSachDanhGia as $tp) {
                $output .= '<div class="comment-item par">
            <div class="item-top">
                <p class="txtname" style="text-transform:none;">' . $tp->username . '</p>
            </div>
            <div class="item-rate">
                <div class="comment-star">';
                if ($tp->so_sao > 4.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>';
                } elseif ($tp->so_sao > 3.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 2.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 1.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 0.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } else {
                    $output .= ' <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                }
                $output .= '</div>
            </div>
            <div class="comment-content">
                <p class="cmt-txt">' . $tp->noi_dung . '</p>
            </div>

            <div class="item-click">
                <a href="javascript:showRatingCmtChild(' . '`' . $tp->username . '`' . ')" class="click-cmt">
                    <i class="icondetail-comment"></i>
                    <span class="cmtr">Thảo luận</span>
                </a>
                <div class="' . $tp->username . ' reply hide">
                    <input placeholder="Nhập thảo luận của bạn" style="color: #3e5569;"
                    name="noidung" id="noidung">
                    <input type="hidden" value="' . $tp->id . '" name="danhgiaid">
                    <a href="javascript:themPhanHoi();" class="rrSend">GỬI</a>
                </div>
            </div>
        </div>
        <div class="phanhoi">';
                if (count($danhSachPhanHoi) > 0) {
                    foreach ($danhSachPhanHoi as $ph) {
                        if ($ph->danh_gia_id == $tp->id) {
                            $output .= '<div
                        class="comment-item ' . $tp->username . ' childC-item hide">
                        <div class="item-top">
                            <p class="txtname" style="text-transform:none">' . $ph->username . '</p>';
                            if ($ph->loai_tai_khoan_id < 5) {
                                $output .= '<span class="qtv">QTV</span>';
                            }
                            $output .= '</div>
                        <div class="item-rate">
                        </div>
                        <div class="comment-content">
                            <p class="cmt-txt">' . $ph->noi_dung . '</p>
                        </div>
                    </div>';
                        }
                    }
                }
                $output .= '</div>';
            }
        } elseif ($request->sosao == 4) {
            $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
                ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
                ->where('danh_gias.dien_thoai_id', '=', $request->dienThoaiId)
                ->where('danh_gias.so_sao', '=', 4)
                ->where('danh_gias.trang_thai', '=', 1)
                ->select('danh_gias.*', 'tai_khoans.username')
                ->get();
            if (count($danhSachDanhGia) == 0) {
                $output .= '
                        <p style="width: 450px;text-align:center"><img src=' . asset('assets/user/images/data-not-found.png') . ' width="150"></p>
                        <p style="width: 450px;text-align:center;font-weight: bold;">Không có đánh giá !</p>';
                return response()->json($output);
            }
            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
                ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();

            foreach ($danhSachDanhGia as $tp) {
                $output .= '<div class="comment-item par">
            <div class="item-top">
                <p class="txtname" style="text-transform:none;">' . $tp->username . '</p>
            </div>
            <div class="item-rate">
                <div class="comment-star">';
                if ($tp->so_sao > 4.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>';
                } elseif ($tp->so_sao > 3.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 2.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 1.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 0.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } else {
                    $output .= ' <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                }
                $output .= '</div>
            </div>
            <div class="comment-content">
                <p class="cmt-txt">' . $tp->noi_dung . '</p>
            </div>

            <div class="item-click">
                <a href="javascript:showRatingCmtChild(' . '`' . $tp->username . '`' . ')" class="click-cmt">
                    <i class="icondetail-comment"></i>
                    <span class="cmtr">Thảo luận</span>
                </a>
                <div class="' . $tp->username . ' reply hide">
                    <input placeholder="Nhập thảo luận của bạn" style="color: #3e5569;"
                    name="noidung" id="noidung">
                    <input type="hidden" value="' . $tp->id . '" name="danhgiaid">
                    <a href="javascript:themPhanHoi();" class="rrSend">GỬI</a>
                </div>
            </div>
        </div>
        <div class="phanhoi">';
                if (count($danhSachPhanHoi) > 0) {
                    foreach ($danhSachPhanHoi as $ph) {
                        if ($ph->danh_gia_id == $tp->id) {
                            $output .= '<div
                        class="comment-item ' . $tp->username . ' childC-item hide">
                        <div class="item-top">
                            <p class="txtname" style="text-transform:none">' . $ph->username . '</p>';
                            if ($ph->loai_tai_khoan_id < 5) {
                                $output .= '<span class="qtv">QTV</span>';
                            }
                            $output .= '</div>
                        <div class="item-rate">
                        </div>
                        <div class="comment-content">
                            <p class="cmt-txt">' . $ph->noi_dung . '</p>
                        </div>
                    </div>';
                        }
                    }
                }
                $output .= '</div>';
            }
        } elseif ($request->sosao == 5) {
            $danhSachDanhGia = DanhGia::join('dien_thoais', 'dien_thoais.id', '=', 'danh_gias.dien_thoai_id')
                ->join('tai_khoans', 'tai_khoans.id', '=', 'danh_gias.tai_khoan_id')
                ->where('danh_gias.dien_thoai_id', '=', $request->dienThoaiId)
                ->where('danh_gias.so_sao', '=', 5)
                ->where('danh_gias.trang_thai', '=', 1)
                ->select('danh_gias.*', 'tai_khoans.username')
                ->get();
            if (count($danhSachDanhGia) == 0) {
                $output .= '
                        <p style="width: 450px;text-align:center"><img src=' . asset('assets/user/images/data-not-found.png') . ' width="150"></p>
                        <p style="width: 450px;text-align:center;font-weight: bold;">Không có đánh giá !</p>';
                return response()->json($output);
            }
            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
            ->where('phan_hoi_danh_gias.trang_thai', '=', 1)
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();

            foreach ($danhSachDanhGia as $tp) {
                $output .= '<div class="comment-item par">
            <div class="item-top">
                <p class="txtname" style="text-transform:none;">' . $tp->username . '</p>
            </div>
            <div class="item-rate">
                <div class="comment-star">';
                if ($tp->so_sao > 4.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>';
                } elseif ($tp->so_sao > 3.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 2.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 1.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } elseif ($tp->so_sao > 0.5) {
                    $output .= '<i class="icon-star"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                } else {
                    $output .= ' <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>
                        <i class="icon-star-dark"></i>';
                }
                $output .= '</div>
            </div>
            <div class="comment-content">
                <p class="cmt-txt">' . $tp->noi_dung . '</p>
            </div>

            <div class="item-click">
                <a href="javascript:showRatingCmtChild(' . '`' . $tp->username . '`' . ')" class="click-cmt">
                    <i class="icondetail-comment"></i>
                    <span class="cmtr">Thảo luận</span>
                </a>
                <div class="' . $tp->username . ' reply hide">
                    <input placeholder="Nhập thảo luận của bạn" style="color: #3e5569;"
                    name="noidung" id="noidung">
                    <input type="hidden" value="' . $tp->id . '" name="danhgiaid">
                    <a href="javascript:themPhanHoi();" class="rrSend">GỬI</a>
                </div>
            </div>
        </div>
        <div class="phanhoi">';
                if (count($danhSachPhanHoi) > 0) {
                    foreach ($danhSachPhanHoi as $ph) {
                        if ($ph->danh_gia_id == $tp->id) {
                            $output .= '<div
                        class="comment-item ' . $tp->username . ' childC-item hide">
                        <div class="item-top">
                            <p class="txtname" style="text-transform:none">' . $ph->username . '</p>';
                            if ($ph->loai_tai_khoan_id < 5) {
                                $output .= '<span class="qtv">QTV</span>';
                            }
                            $output .= '</div>
                        <div class="item-rate">
                        </div>
                        <div class="comment-content">
                            <p class="cmt-txt">' . $ph->noi_dung . '</p>
                        </div>
                    </div>';
                        }
                    }
                }
                $output .= '</div>';
            }
        }
        return response()->json($output);
    }
}
