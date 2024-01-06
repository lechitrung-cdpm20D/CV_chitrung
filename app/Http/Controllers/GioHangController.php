<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Models\ChiTietDienThoai;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\HinhAnhMauSacCuaDienThoai;
use App\Models\PhieuGiamGia;
use App\Models\ThongTinTaiKhoan;
use App\Models\CuaHang;
use App\Models\SanPhamPhanBo;
use App\Models\Kho;
use App\Models\ChiTietKho;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GioHangController extends Controller
{
    public function addCart(Request $request)
    {
        $output = '';
        $product = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
            ->where('chi_tiet_dien_thoais.id', '=', $request->input('idChiTiet'))
            ->select(
                'chi_tiet_dien_thoais.id',
                'chi_tiet_dien_thoais.dien_thoai_id',
                'chi_tiet_dien_thoais.gia',
                'bo_nho_luu_trus.ram',
                'bo_nho_luu_trus.bo_nho_trong',
                'mau_sacs.ten_mau_sac',
                'chi_tiet_dien_thoais.mau_sac_id',
                'dien_thoais.ten_san_pham',
            )
            ->first();

        $khuyenMai = ChiTietKhuyenMai::where('dien_thoai_id', '=', $product->dien_thoai_id)->first();
        if (!empty($khuyenMai)) {
            $thoiGianKhuyenMai = KhuyenMai::where('id', '=', $khuyenMai->khuyen_mai_id)->first();
            if (strtotime($thoiGianKhuyenMai->ngay_ket_thuc) >= strtotime(date("Y-m-d"))) {
                $product->phan_tram_giam = $khuyenMai->phan_tram_giam;
            } else {
                $product->phan_tram_giam = 0;
            }
        } else {
            $product->phan_tram_giam = 0;
        }

        $hinhAnhMauSac = HinhAnhMauSacCuaDienThoai::where('dien_thoai_id', '=', $product->dien_thoai_id)
            ->where('mau_sac_id', '=', $product->mau_sac_id)
            ->where('hinh_anh_dai_dien', '=', 1)
            ->first();
        $product->hinh_anh = $hinhAnhMauSac->hinh_anh;

        $soLuong = 0;
        if ($product != null) {
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->addCart($product, $request->input('idChiTiet'));
            $request->session()->put('Cart', $newCart);
            $soLuong = 0;
            foreach (Session('Cart')->products as $tp) {
                $soLuong += $tp['quantity'];
            }
            $output .=  '<i class="icon-cart">' . $soLuong . '</i>
            <span>Giỏ hàng</span>';
            return response()->json($output);
        }
    }

    public function deleteItemCart(Request $request)
    {
        $output = '';
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->deleteItemCart($request->input('idChiTiet'));
        $phanTramGiamVoucher = 0;
        if (Session('Cart')->voucher != null) {
            $voucher = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
            $phanTramGiamVoucher = $voucher->phan_tram_giam;
        }

        if (count($newCart->products) > 0) {
            $request->session()->put('Cart', $newCart);
            $soLuong = 0;
            foreach (Session('Cart')->products as $tp) {
                $soLuong += $tp['quantity'];
            }
            $output .=  '<section class="wrapper cart" style="padding: 20px 0;">
            <div style="margin: auto;">
                <ul class="list-cart">';
            foreach (Session('Cart')->products as $tp) {
                $output .= '<li class="product-item">
                        <div class="img-product">
                            <a
                                href="' . route("productDetail", ["sanPhamId" => $tp["productInfo"]->dien_thoai_id]) . '">
                                <img src="' . asset('storage/images/' . $tp['productInfo']->hinh_anh) . '" />
                            </a>
                            <button onclick="deleteItemCart(' . $tp['productInfo']->id . ')"><i
                                    class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="info-product">
                            <div class="name-price">
                                <div class="name">
                                    <a href="' . route('productDetail', ['sanPhamId' => $tp['productInfo']->dien_thoai_id]) . '"
                                        class="product-item-name">
                                        Điện thoại ' . $tp['productInfo']->ten_san_pham . '
                                        ' . $tp['productInfo']->ram . '/' . $tp['productInfo']->bo_nho_trong . ' -
                                        ' . $tp['productInfo']->ten_mau_sac . '</a>
                                </div>';
                if ($tp['productInfo']->phan_tram_giam == 0) {
                    $output .= '<span> ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher)), 0, ',', '.') . '₫</span>';
                } else {
                    $output .= '<span>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher)), 0, ',', '.') . '₫<del>
                                        ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫ </del>
                                        <p style="display: inline;color: #666;">Giảm giá ' . ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher) * 100 . '%</p>
                                        </span>';
                }
                $output .= '</div>
                            <hr style="width: 65%; visibility: hidden;">
                        </div>
                        <div class="choose-color">
                        <div class="choosenumber">';
                if ($tp['quantity'] == 1) {
                    $output .= '<div class="minus" style="pointer-events: none;" onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                            style="background-color: rgb(204, 204, 204);"></i></div>';
                } else {
                    $output .= '<div class="minus" style="pointer-events: all;"
                            onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                style="background-color: rgb(40, 138, 214);"></i></div>';
                }
                $output .= '<input type="text" class="number" style="border: none; pointer-events: all;"
                                value="' . $tp['quantity'] . '" readonly id="' . $tp['productInfo']->id . '">
                            <div class="plus" style="pointer-events: all;" onclick="plusQuantity(' . $tp['productInfo']->id . ')"><i
                                    style="background-color: rgb(40, 138, 214);"></i><i
                                    style="background-color: rgb(40, 138, 214);"></i></div>
                            <input type="hidden">
                        </div>
                    </div>
                    </li>';
            }
            $tamTinh = 0;
            foreach (Session('Cart')->products as $tp) {
                $tamTinh += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
            }
            if ($phanTramGiamVoucher > 0) {
                $output .= '<div class="total-provisional">
                        <span class="total-product-quantity">
                            <span class="total-label">Áp dụng mã giảm giá: ' . $voucher->code . '</span>
                        </span>
                        <span class="temp-total-money" style="font-weight: bold">Giảm ' . ($phanTramGiamVoucher * 100) . '% (Đã cộng vào % giảm mỗi SP)</span>
                    </div>';
            }
            $output .= '<div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Tạm tính </span>(' . $soLuong . ' sản phẩm):
                    </span>
                    <span class="temp-total-money">' . number_format($tamTinh, 0, ',', '.') . '₫</span>
                </div>
                <div class="finaltotal">
                    <div class="area-total">
                        <div class="discountcode">
                            <div class="usecode coupon-code singlebox" id="myDIV" onclick="maKhuyenMai()">
                                <div class="usecode-icon"><i class="fas fa-receipt"></i></div><span
                                    class="usecode-title">Dùng
                                    mã
                                    giảm giá</span>
                            </div>
                            <div class="clr"></div>
                            <div class="applycode">
                                <div class="applycode-text-input"><input maxlength="20" placeholder="Nhập mã giảm giá" id="maGiamGia">
                                </div>
                                <div class="applycode-button"><button type="button" onclick="checkVoucher()">
                                        Áp dụng </button></div>
                                <!---->
                            </div>
                            <div class="line-break"></div>
                        </div>
                        <div class="total-price"><strong>Tổng
                                tiền:</strong><strong>' . number_format($tamTinh, 0, ',', '.') . '₫</strong></div>
                            <a href="/confirm"><button type="button" class="submitorder"><b
                                        style="text-transform:uppercase">Đặt
                                        hàng</b></button></a>
                        </div>
                    </div>
                </div>
                </section>';
            return response()->json($output);
        } else {
            $request->session()->forget('Cart');
            $output .= '<section>
            <div class="cartempty"><i class="cartnew-empty"></i><span>Không có sản phẩm nào trong giỏ hàng</span><a
                    href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
            </div>
            </section>';
            return response()->json($output);
        }
    }

    public function plusItemCart(Request $request)
    {
        $output = '';
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->plusItemCart($request->input('idChiTiet'));
        $request->session()->put('Cart', $newCart);
        $soLuong = 0;
        $phanTramGiamVoucher = 0;
        if (Session('Cart')->voucher != null) {
            $voucher = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
            $phanTramGiamVoucher = $voucher->phan_tram_giam;
        }

        foreach (Session('Cart')->products as $tp) {
            $soLuong += $tp['quantity'];
        }
        $output .=  '<section class="wrapper cart" style="padding: 20px 0;">
            <div style="margin: auto;">
                <ul class="list-cart">';
        foreach (Session('Cart')->products as $tp) {
            $output .= '<li class="product-item">
                        <div class="img-product">
                            <a
                                href="' . route("productDetail", ["sanPhamId" => $tp["productInfo"]->dien_thoai_id]) . '">
                                <img src="' . asset('storage/images/' . $tp['productInfo']->hinh_anh) . '" />
                            </a>
                            <button onclick="deleteItemCart(' . $tp['productInfo']->id . ')"><i
                                    class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="info-product">
                            <div class="name-price">
                                <div class="name">
                                    <a href="' . route('productDetail', ['sanPhamId' => $tp['productInfo']->dien_thoai_id]) . '"
                                        class="product-item-name">
                                        Điện thoại ' . $tp['productInfo']->ten_san_pham . '
                                        ' . $tp['productInfo']->ram . '/' . $tp['productInfo']->bo_nho_trong . ' -
                                        ' . $tp['productInfo']->ten_mau_sac . '</a>
                                </div>';
            if ($tp['productInfo']->phan_tram_giam == 0) {
                $output .= '<span> ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher)), 0, ',', '.') . '₫</span>';
            } else {
                $output .= '<span>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher)), 0, ',', '.') . '₫<del>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫ </del>
                                    <p style="display: inline;color: #666;">Giảm giá ' . ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher) * 100 . '%</p>
                                    </span>';
            }
            $output .= '</div>
                            <hr style="width: 65%; visibility: hidden;">
                        </div>
                        <div class="choose-color">
                            <div class="choosenumber">';
            if ($tp['quantity'] == 1) {
                $output .= '<div class="minus" style="pointer-events: none;" onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                style="background-color: rgb(204, 204, 204);"></i></div>';
            } else {
                $output .= '<div class="minus" style="pointer-events: all;"
                                onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                    style="background-color: rgb(40, 138, 214);"></i></div>';
            }
            $output .= '<input type="text" class="number" style="border: none; pointer-events: all;"
                                    value="' . $tp['quantity'] . '" readonly id="' . $tp['productInfo']->id . '">
                                <div class="plus" style="pointer-events: all;" onclick="plusQuantity(' . $tp['productInfo']->id . ')"><i
                                        style="background-color: rgb(40, 138, 214);"></i><i
                                        style="background-color: rgb(40, 138, 214);"></i></div>
                                <input type="hidden">
                            </div>
                        </div>
                    </li>';
        }
        $tamTinh = 0;
        foreach (Session('Cart')->products as $tp) {
            $tamTinh += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
        }
        $output .= '</ul>';
        if ($phanTramGiamVoucher > 0) {
            $output .= '<div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Áp dụng mã giảm giá: ' . $voucher->code . '</span>
                    </span>
                    <span class="temp-total-money" style="font-weight: bold">Giảm ' . ($phanTramGiamVoucher * 100) . '% (Đã cộng vào % giảm mỗi SP)</span>
                </div>';
        }
        $output .= '<div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Tạm tính </span>(' . $soLuong . ' sản phẩm):
                    </span>
                    <span class="temp-total-money">' . number_format($tamTinh, 0, ',', '.') . '₫</span>
                </div>
                <div class="finaltotal">
                    <div class="area-total">
                        <div class="discountcode">
                            <div class="usecode coupon-code singlebox" id="myDIV" onclick="maKhuyenMai()">
                                <div class="usecode-icon"><i class="fas fa-receipt"></i></div><span
                                    class="usecode-title">Dùng
                                    mã
                                    giảm giá</span>
                            </div>
                            <div class="clr"></div>
                            <div class="applycode">
                                <div class="applycode-text-input"><input maxlength="20" placeholder="Nhập mã giảm giá" id="maGiamGia">
                                </div>
                                <div class="applycode-button"><button type="button" onclick="checkVoucher()">
                                        Áp dụng </button></div>
                                <!---->
                            </div>
                            <div class="line-break"></div>
                        </div>
                        <div class="total-price"><strong>Tổng
                                tiền:</strong><strong>' . number_format($tamTinh, 0, ',', '.') . '₫</strong></div>
                            <a href="/confirm"><button type="button" class="submitorder"><b
                                        style="text-transform:uppercase">Đặt
                                        hàng</b></button></a>
                        </div>
                    </div>
                </div>
                </section>';
        return response()->json($output);
    }

    public function minusItemCart(Request $request)
    {
        $output = '';
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->minusItemCart($request->input('idChiTiet'));
        $request->session()->put('Cart', $newCart);
        $soLuong = 0;
        $phanTramGiamVoucher = 0;
        if (Session('Cart')->voucher != null) {
            $voucher = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
            $phanTramGiamVoucher = $voucher->phan_tram_giam;
        }

        foreach (Session('Cart')->products as $tp) {
            $soLuong += $tp['quantity'];
        }
        $output .=  '<section class="wrapper cart" style="padding: 20px 0;">
            <div style="margin: auto;">
                <ul class="list-cart">';
        foreach (Session('Cart')->products as $tp) {
            $output .= '<li class="product-item">
                        <div class="img-product">
                            <a
                                href="' . route("productDetail", ["sanPhamId" => $tp["productInfo"]->dien_thoai_id]) . '">
                                <img src="' . asset('storage/images/' . $tp['productInfo']->hinh_anh) . '" />
                            </a>
                            <button onclick="deleteItemCart(' . $tp['productInfo']->id . ')"><i
                                    class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="info-product">
                            <div class="name-price">
                                <div class="name">
                                    <a href="' . route('productDetail', ['sanPhamId' => $tp['productInfo']->dien_thoai_id]) . '"
                                        class="product-item-name">
                                        Điện thoại ' . $tp['productInfo']->ten_san_pham . '
                                        ' . $tp['productInfo']->ram . '/' . $tp['productInfo']->bo_nho_trong . ' -
                                        ' . $tp['productInfo']->ten_mau_sac . '</a>
                                </div>';
            if ($tp['productInfo']->phan_tram_giam == 0) {
                $output .= '<span> ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher)), 0, ',', '.') . '₫</span>';
            } else {
                $output .= '<span>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher)), 0, ',', '.') . '₫<del>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫ </del>
                                    <p style="display: inline;color: #666;">Giảm giá ' . ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher) * 100 . '%</p>
                                    </span>';
            }
            $output .= '</div>
                            <hr style="width: 65%; visibility: hidden;">
                        </div>
                        <div class="choose-color">
                            <div class="choosenumber">';
            if ($tp['quantity'] == 1) {
                $output .= '<div class="minus" style="pointer-events: none;" onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                style="background-color: rgb(204, 204, 204);"></i></div>';
            } else {
                $output .= '<div class="minus" style="pointer-events: all;"
                                onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                    style="background-color: rgb(40, 138, 214);"></i></div>';
            }
            $output .= '<input type="text" class="number" style="border: none; pointer-events: all;"
                                    value="' . $tp['quantity'] . '" readonly id="' . $tp['productInfo']->id . '">
                                <div class="plus" style="pointer-events: all;" onclick="plusQuantity(' . $tp['productInfo']->id . ')"><i
                                        style="background-color: rgb(40, 138, 214);"></i><i
                                        style="background-color: rgb(40, 138, 214);"></i></div>
                                <input type="hidden">
                            </div>
                        </div>
                    </li>';
        }
        $tamTinh = 0;
        foreach (Session('Cart')->products as $tp) {
            $tamTinh += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
        }
        $output .= '</ul>';
        if ($phanTramGiamVoucher > 0) {
            $output .= '<div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Áp dụng mã giảm giá: ' . $voucher->code . '</span>
                    </span>
                    <span class="temp-total-money" style="font-weight: bold">Giảm ' . ($phanTramGiamVoucher * 100) . '% (Đã cộng vào % giảm mỗi SP)</span>
                </div>';
        }
        $output .= '<div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Tạm tính </span>(' . $soLuong . ' sản phẩm):
                    </span>
                    <span class="temp-total-money">' . number_format($tamTinh, 0, ',', '.') . '₫</span>
                </div>
                <div class="finaltotal">
                    <div class="area-total">
                        <div class="discountcode">
                            <div class="usecode coupon-code singlebox" id="myDIV" onclick="maKhuyenMai()">
                                <div class="usecode-icon"><i class="fas fa-receipt"></i></div><span
                                    class="usecode-title">Dùng
                                    mã
                                    giảm giá</span>
                            </div>
                            <div class="clr"></div>
                            <div class="applycode">
                                <div class="applycode-text-input"><input maxlength="20" placeholder="Nhập mã giảm giá" id="maGiamGia">
                                </div>
                                <div class="applycode-button"><button type="button" onclick="checkVoucher()">
                                        Áp dụng </button></div>
                                <!---->
                            </div>
                            <div class="line-break"></div>
                        </div>
                        <div class="total-price"><strong>Tổng
                                tiền:</strong><strong>' . number_format($tamTinh, 0, ',', '.') . '₫</strong></div>
                            <a href="/confirm"><button type="button" class="submitorder"><b
                                        style="text-transform:uppercase">Đặt
                                        hàng</b></button></a>
                        </div>
                    </div>
                </div>
                </section>';
        return response()->json($output);
    }

    public function checkVoucher(Request $request)
    {
        $voucher = PhieuGiamGia::where('code', '=', $request->code)->first();
        $output = '';
        $soLuong = 0;
        foreach (Session('Cart')->products as $tp) {
            $soLuong += $tp['quantity'];
        }
        if (!empty($voucher)) {
            if (strtotime($voucher->ngay_het_han) >= strtotime(date("Y-m-d"))) {
                $oldCart = Session('Cart') ? Session('Cart') : null;
                $newCart = new Cart($oldCart);
                $newCart->addVoucher($voucher);
                $request->session()->put('Cart', $newCart);
                $output .=  '<section class="wrapper cart" style="padding: 20px 0;">
            <div style="margin: auto;">
                <ul class="list-cart">';
                foreach (Session('Cart')->products as $tp) {
                    $output .= '<li class="product-item">
                        <div class="img-product">
                            <a
                                href="' . route("productDetail", ["sanPhamId" => $tp["productInfo"]->dien_thoai_id]) . '">
                                <img src="' . asset('storage/images/' . $tp['productInfo']->hinh_anh) . '" />
                            </a>
                            <button onclick="deleteItemCart(' . $tp['productInfo']->id . ')"><i
                                    class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="info-product">
                            <div class="name-price">
                                <div class="name">
                                    <a href="' . route('productDetail', ['sanPhamId' => $tp['productInfo']->dien_thoai_id]) . '"
                                        class="product-item-name">
                                        Điện thoại ' . $tp['productInfo']->ten_san_pham . '
                                        ' . $tp['productInfo']->ram . '/' . $tp['productInfo']->bo_nho_trong . ' -
                                        ' . $tp['productInfo']->ten_mau_sac . '</a>
                                </div>';
                    if ($tp['productInfo']->phan_tram_giam == 0) {
                        $output .= '<span> ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + Session('Cart')->voucher['phan_tram_giam'])), 0, ',', '.') . '₫</span>';
                    } else {
                        $output .= '<span>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * ($tp['productInfo']->phan_tram_giam + Session('Cart')->voucher['phan_tram_giam'])), 0, ',', '.') . '₫<del>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫ </del>
                                    <p style="display: inline;color: #666;">Giảm giá ' . ($tp['productInfo']->phan_tram_giam + Session('Cart')->voucher['phan_tram_giam']) * 100 . '%</p>
                                    </span>';
                    }
                    $output .= '</div>
                            <hr style="width: 65%; visibility: hidden;">
                        </div>
                        <div class="choose-color">
                            <div class="choosenumber">';
                    if ($tp['quantity'] == 1) {
                        $output .= '<div class="minus" style="pointer-events: none;" onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                style="background-color: rgb(204, 204, 204);"></i></div>';
                    } else {
                        $output .= '<div class="minus" style="pointer-events: all;"
                                onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                    style="background-color: rgb(40, 138, 214);"></i></div>';
                    }
                    $output .= '<input type="text" class="number" style="border: none; pointer-events: all;"
                                    value="' . $tp['quantity'] . '" readonly id="' . $tp['productInfo']->id . '">
                                <div class="plus" style="pointer-events: all;" onclick="plusQuantity(' . $tp['productInfo']->id . ')"><i
                                        style="background-color: rgb(40, 138, 214);"></i><i
                                        style="background-color: rgb(40, 138, 214);"></i></div>
                                <input type="hidden">
                            </div>
                        </div>
                    </li>';
                }
                $tamTinh = 0;
                $soTienGiamTuKM = 0;
                foreach (Session('Cart')->products as $tp) {
                    $tamTinh += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + Session('Cart')->voucher['phan_tram_giam']));
                }
                $output .= '</ul>
                <div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Áp dụng mã giảm giá: ' . $voucher->code . '</span>
                    </span>
                    <span class="temp-total-money" style="font-weight: bold">Giảm ' . (Session('Cart')->voucher['phan_tram_giam'] * 100) . '% (Đã cộng vào % giảm mỗi SP)</span>
                </div>
                <div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Tạm tính </span>(' . $soLuong . ' sản phẩm):
                    </span>
                    <span class="temp-total-money">' . number_format($tamTinh, 0, ',', '.') . '₫</span>
                </div>
                <div class="finaltotal">
                    <div class="area-total">
                        <div class="discountcode">
                            <div class="usecode coupon-code singlebox" id="myDIV" onclick="maKhuyenMai()">
                                <div class="usecode-icon"><i class="fas fa-receipt"></i></div><span
                                    class="usecode-title">Dùng
                                    mã
                                    giảm giá</span>
                            </div>
                            <div class="clr"></div>
                            <div class="applycode">
                                <div class="applycode-text-input"><input maxlength="20" placeholder="Nhập mã giảm giá" id="maGiamGia">
                                </div>
                                <div class="applycode-button"><button type="button" onclick="checkVoucher()">
                                        Áp dụng </button></div>
                                <!---->
                            </div>
                            <div class="line-break"></div>
                        </div>
                        <div class="total-price"><strong>Tổng
                                tiền:</strong><strong>' . number_format($tamTinh, 0, ',', '.') . '₫</strong></div>
                            <a href="/confirm"><button type="button" class="submitorder"><b
                                        style="text-transform:uppercase">Đặt
                                        hàng</b></button></a>
                        </div>
                    </div>
                </div>
                </section>';
                return response()->json($output);
            } else {
                $output .=  '<section class="wrapper cart" style="padding: 20px 0;">
            <div style="margin: auto;">
                <ul class="list-cart">';
                foreach (Session('Cart')->products as $tp) {
                    $output .= '<li class="product-item">
                        <div class="img-product">
                            <a
                                href="' . route("productDetail", ["sanPhamId" => $tp["productInfo"]->dien_thoai_id]) . '">
                                <img src="' . asset('storage/images/' . $tp['productInfo']->hinh_anh) . '" />
                            </a>
                            <button onclick="deleteItemCart(' . $tp['productInfo']->id . ')"><i
                                    class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="info-product">
                            <div class="name-price">
                                <div class="name">
                                    <a href="' . route('productDetail', ['sanPhamId' => $tp['productInfo']->dien_thoai_id]) . '"
                                        class="product-item-name">
                                        Điện thoại ' . $tp['productInfo']->ten_san_pham . '
                                        ' . $tp['productInfo']->ram . '/' . $tp['productInfo']->bo_nho_trong . ' -
                                        ' . $tp['productInfo']->ten_mau_sac . '</a>
                                </div>';
                    if ($tp['productInfo']->phan_tram_giam == 0) {
                        $output .= '<span> ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫</span>';
                    } else {
                        $output .= '<span>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * $tp['productInfo']->phan_tram_giam), 0, ',', '.') . '<del>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫ </del>
                                    <p style="display: inline;color: #666;">Giảm giá ' . ($tp['productInfo']->phan_tram_giam) * 100 . '%</p>
                                    </span>';
                    }
                    $output .= '</div>
                            <hr style="width: 65%; visibility: hidden;">
                        </div>
                        <div class="choose-color">
                            <div class="choosenumber">';
                    if ($tp['quantity'] == 1) {
                        $output .= '<div class="minus" style="pointer-events: none;" onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                style="background-color: rgb(204, 204, 204);"></i></div>';
                    } else {
                        $output .= '<div class="minus" style="pointer-events: all;"
                                onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                    style="background-color: rgb(40, 138, 214);"></i></div>';
                    }
                    $output .= '<input type="text" class="number" style="border: none; pointer-events: all;"
                                    value="' . $tp['quantity'] . '" readonly id="' . $tp['productInfo']->id . '">
                                <div class="plus" style="pointer-events: all;" onclick="plusQuantity(' . $tp['productInfo']->id . ')"><i
                                        style="background-color: rgb(40, 138, 214);"></i><i
                                        style="background-color: rgb(40, 138, 214);"></i></div>
                                <input type="hidden">
                            </div>
                        </div>
                    </li>';
                }
                $tamTinh = 0;
                foreach (Session('Cart')->products as $tp) {
                    $tamTinh += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * $tp['productInfo']->phan_tram_giam);
                }
                $output .= '</ul>
                <div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Tạm tính </span>(' . $soLuong . ' sản phẩm):
                    </span>
                    <span class="temp-total-money">' . number_format($tamTinh, 0, ',', '.') . '₫</span>
                </div>
                <div class="finaltotal">
                    <div class="area-total">
                        <div class="discountcode">
                            <div class="usecode coupon-code singlebox active" id="myDIV" onclick="maKhuyenMai()">
                                <div class="usecode-icon"><i class="fas fa-receipt"></i></div><span
                                    class="usecode-title">Dùng
                                    mã
                                    giảm giá</span>
                            </div>
                            <div class="clr"></div>
                            <div class="applycode active">
                                <div class="applycode-text-input"><input maxlength="20" placeholder="Nhập mã giảm giá" id="maGiamGia">
                                </div>
                                <div class="applycode-button"><button type="button" onclick="checkVoucher()">
                                        Áp dụng </button></div>
                                <small>Mã giảm giá đã hết hạn</small>
                                <!---->
                            </div>
                            <div class="line-break"></div>
                        </div>
                        <div class="total-price"><strong>Tổng
                                tiền:</strong><strong>' . number_format($tamTinh, 0, ',', '.') . '₫</strong></div>
                            <a href="/confirm"><button type="button" class="submitorder"><b
                                        style="text-transform:uppercase">Đặt
                                        hàng</b></button></a>
                        </div>
                    </div>
                </div>
                </section>';
                return response()->json($output);
            }
        }
        $output .=  '<section class="wrapper cart" style="padding: 20px 0;">
            <div style="margin: auto;">
                <ul class="list-cart">';
        foreach (Session('Cart')->products as $tp) {
            $output .= '<li class="product-item">
                        <div class="img-product">
                            <a
                                href="' . route("productDetail", ["sanPhamId" => $tp["productInfo"]->dien_thoai_id]) . '">
                                <img src="' . asset('storage/images/' . $tp['productInfo']->hinh_anh) . '" />
                            </a>
                            <button onclick="deleteItemCart(' . $tp['productInfo']->id . ')"><i
                                    class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="info-product">
                            <div class="name-price">
                                <div class="name">
                                    <a href="' . route('productDetail', ['sanPhamId' => $tp['productInfo']->dien_thoai_id]) . '"
                                        class="product-item-name">
                                        Điện thoại ' . $tp['productInfo']->ten_san_pham . '
                                        ' . $tp['productInfo']->ram . '/' . $tp['productInfo']->bo_nho_trong . ' -
                                        ' . $tp['productInfo']->ten_mau_sac . '</a>
                                </div>';
            if ($tp['productInfo']->phan_tram_giam == 0) {
                $output .= '<span> ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫</span>';
            } else {
                $output .= '<span>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'] - ($tp['productInfo']->gia * $tp['quantity'] * $tp['productInfo']->phan_tram_giam), 0, ',', '.') . '<del>
                                    ' . number_format($tp['productInfo']->gia * $tp['quantity'], 0, ',', '.') . '₫ </del>
                                    <p style="display: inline;color: #666;">Giảm giá ' . ($tp['productInfo']->phan_tram_giam) * 100 . '%</p>
                                    </span>';
            }
            $output .= '</div>
                            <hr style="width: 65%; visibility: hidden;">
                        </div>
                        <div class="choose-color">
                            <div class="choosenumber">';
            if ($tp['quantity'] == 1) {
                $output .= '<div class="minus" style="pointer-events: none;" onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                style="background-color: rgb(204, 204, 204);"></i></div>';
            } else {
                $output .= '<div class="minus" style="pointer-events: all;"
                                onclick="minusQuantity(' . $tp['productInfo']->id . ')"><i
                                    style="background-color: rgb(40, 138, 214);"></i></div>';
            }
            $output .= '<input type="text" class="number" style="border: none; pointer-events: all;"
                                    value="' . $tp['quantity'] . '" readonly id="' . $tp['productInfo']->id . '">
                                <div class="plus" style="pointer-events: all;" onclick="plusQuantity(' . $tp['productInfo']->id . ')"><i
                                        style="background-color: rgb(40, 138, 214);"></i><i
                                        style="background-color: rgb(40, 138, 214);"></i></div>
                                <input type="hidden">
                            </div>
                        </div>
                    </li>';
        }
        $tamTinh = 0;
        foreach (Session('Cart')->products as $tp) {
            $tamTinh += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * $tp['productInfo']->phan_tram_giam);
        }
        $output .= '</ul>
                <div class="total-provisional">
                    <span class="total-product-quantity">
                        <span class="total-label">Tạm tính </span>(' . $soLuong . ' sản phẩm):
                    </span>
                    <span class="temp-total-money">' . number_format($tamTinh, 0, ',', '.') . '₫</span>
                </div>
                <div class="finaltotal">
                    <div class="area-total">
                        <div class="discountcode">
                            <div class="usecode coupon-code singlebox active" id="myDIV" onclick="maKhuyenMai()">
                                <div class="usecode-icon"><i class="fas fa-receipt"></i></div><span
                                    class="usecode-title">Dùng
                                    mã
                                    giảm giá</span>
                            </div>
                            <div class="clr"></div>
                            <div class="applycode active">
                                <div class="applycode-text-input"><input maxlength="20" placeholder="Nhập mã giảm giá" id="maGiamGia">
                                </div>
                                <div class="applycode-button"><button type="button" onclick="checkVoucher()">
                                        Áp dụng </button></div>
                                <small>Mã giảm giá không hợp lệ</small>
                                <!---->
                            </div>
                            <div class="line-break"></div>
                        </div>
                        <div class="total-price"><strong>Tổng
                                tiền:</strong><strong>' . number_format($tamTinh, 0, ',', '.') . '₫</strong></div>
                            <a href="/confirm"><button type="button" class="submitorder"><b
                                        style="text-transform:uppercase">Đặt
                                        hàng</b></button></a>
                        </div>
                    </div>
                </div>
                </section>';
        return response()->json($output);
    }

    public function confirmOrderAddress()
    {
        if (Auth::guest()) {
            return redirect()->intended('/signin');
        }
        $danhSachCuaHang = CuaHang::where('id', '!=', 1)->get();
        foreach ($danhSachCuaHang as $ch) {
            $ch->trang_thai_san_pham = 'Còn hàng';
        }
        if (Session('Cart') != null) {
            foreach (Session('Cart')->products as $tp) {
                foreach ($danhSachCuaHang as $ch) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', $ch->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($sPPB != null) {
                        if ($sPPB->so_luong < $tp['quantity']) {
                            $ch->trang_thai_san_pham = 'Hết hàng';
                        }
                    } else {
                        $ch->trang_thai_san_pham = 'Hết hàng';
                    }
                }
            }
            $user = Auth::user();
            $infoUser = ThongTinTaiKhoan::where('tai_khoan_id', '=', $user->id)->first();
            return view('user/confirm-order-address', ['infoUser' => $infoUser, 'danhSachCuaHang' => $danhSachCuaHang]);
        }
        return view('user/cart');
    }

    public function xacNhanThongTin(Request $request)
    {
        //Nhận hàng theo địa chỉ của khách hàng
        if ($request->cachThucNhan == 'tab-1') {
            $validated = Validator::make(
                $request->all(),
                [
                    'hoTen' => 'required|max:30',
                    'gioiTinh' => 'required|in:1,0',
                    'sdt' => 'required|regex:/(09)[0-9]{8}/',
                    'diaChi' => 'required|max:300',
                ],
                $messages = [
                    'required' => ':attribute không được bỏ trống !',
                    'max' => ':attribute vượt quá số ký tự cho phép !',
                    'regex' => ':attribute không hợp lệ ! Vui lòng kiểm tra lại !',
                ],
                [
                    'hoTen' => 'Họ tên khách hàng',
                    'gioiTinh' => 'Giới tính',
                    'sdt' => 'Số điện thoại',
                    'diaChi' => 'Địa chỉ nhận hàng',
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

            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->infoUser($request->hoTen, $request->gioiTinh, $request->sdt, $request->diaChi);
            $newCart->deliveryMethod('1', $request->ghiChu, null);
            $request->session()->put('Cart', $newCart);
            return view('user/pay');
        }
        //Nhận hàng tại cửa hàng
        else {
            $validated = Validator::make(
                $request->all(),
                [
                    'hoTen' => 'required|max:30',
                    'gioiTinh' => 'required|in:1,0',
                    'sdt' => 'required|regex:/(09)[0-9]{8}/',
                ],
                $messages = [
                    'required' => ':attribute không được bỏ trống !',
                    'max' => ':attribute vượt quá số ký tự cho phép !',
                    'regex' => ':attribute không hợp lệ ! Vui lòng kiểm tra lại !',
                ],
                [
                    'hoTen' => 'Họ tên khách hàng',
                    'gioiTinh' => 'Giới tính',
                    'sdt' => 'Số điện thoại',
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

            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->infoUser($request->hoTen, $request->gioiTinh, $request->sdt, $request->diaChi);
            $newCart->deliveryMethod('2', $request->ghiChu, $request->cuaHangId);
            $request->session()->put('Cart', $newCart);
            return view('user/pay');
        }
    }

    public function thanhToan(Request $request)
    {
        if (Session('Cart')->voucher != null) {
            $kiemTraVoucher = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
            if ($kiemTraVoucher != null) {
                if ($kiemTraVoucher->trang_thai == 0) {
                    return response()->json(
                        'Phiếu giảm giá đã được sử dụng cho đơn hàng khác !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
            }
        }
        if ($request->phuongThuc == 1) {
            if (Session('Cart')->deliveryMethod['cachThucNhan'] == 1) {
                $kho = Kho::where('id', '!=', 1)->first();
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($chiTietKho != null) {
                        if ($chiTietKho->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong kho ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $chiTietKho->fill([
                        'so_luong' => $chiTietKho->so_luong - $tp['quantity'],
                    ]);
                    // $chiTietKho->so_luong = $chiTietKho->so_luong - $tp['quantity'];
                    $chiTietKho->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }
                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 1,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 0,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . Session('Cart')->infoUser['diaChi'] . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            } else {
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($sPPB != null) {
                        if ($sPPB->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong cửa hàng ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
            }
            //Trừ số lượng sản phẩm trong cửa hàng
            foreach (Session('Cart')->products as $tp) {
                $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                    ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                    ->first();
                $sPPB->fill([
                    'so_luong' => $sPPB->so_luong - $tp['quantity'],
                ]);
                $sPPB->save();
            }
            $temp = null;
            if (Session('Cart')->voucher != null) {
                $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
            }
            $phanTramGiamVoucher = 0;
            $idPhieuGiamGia = null;
            if ($temp != null) {
                $phanTramGiamVoucher = $temp->phan_tram_giam;
                $idPhieuGiamGia = $temp->id;
                $temp->fill([
                    'trang_thai' => 0,
                ]);
                $temp->save();
            }

            $cuaHang = CuaHang::where('id', '=', Session('Cart')->deliveryMethod['cuaHangId'])->first();
            //Tạo đơn hàng
            $donHang = new DonHang();
            $donHang->fill([
                'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                'tai_khoan_khach_hang_id' => Auth::user()->id,
                'tai_khoan_nhan_vien_id' => null,
                'phieu_giam_gia_id' => $idPhieuGiamGia,
                'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                'dia_chi_nhan_hang' => $cuaHang->dia_chi,
                'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                'phuong_thuc_thanh_toan' => 1,
                'ngay_giao' => null,
                'trang_thai_thanh_toan' => 0,
                'trang_thai_don_hang' => 0,
                'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
            $donHang->save();
            //Tạo chi tiết đơn hàng
            $tongTien = 0;
            foreach (Session('Cart')->products as $tp) {
                $chiTietDonHang = new ChiTietDonHang();
                $chiTietDonHang->fill([
                    'don_hang_id' => $donHang->ma_don_hang,
                    'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                    'gia' => $tp['productInfo']->gia,
                    'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                    'so_luong' => $tp['quantity'],
                ]);
                $chiTietDonHang->save();
                $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
            }

            $gioiTinh = 'Anh';
            if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                $gioiTinh = 'Chị';
            }
            $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . $cuaHang->dia_chi . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
            $details = [
                'ma_don_hang' => $donHang->ma_don_hang,
                'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                'tong_tien' => $tongTien,
            ];
            $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
            Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
            session()->forget('Cart');
            return response()->json($output);
        } else if ($request->phuongThuc == 2) {
            if (Session('Cart')->deliveryMethod['cachThucNhan'] == 1) {
                $kho = Kho::where('id', '!=', 1)->first();
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($chiTietKho != null) {
                        if ($chiTietKho->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong kho ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $chiTietKho->fill([
                        'so_luong' => $chiTietKho->so_luong - $tp['quantity'],
                    ]);
                    // $chiTietKho->so_luong = $chiTietKho->so_luong - $tp['quantity'];
                    $chiTietKho->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }

                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 2,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 1,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . Session('Cart')->infoUser['diaChi'] . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            } else {
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($sPPB != null) {
                        if ($sPPB->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong cửa hàng ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $sPPB->fill([
                        'so_luong' => $sPPB->so_luong - $tp['quantity'],
                    ]);
                    $sPPB->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }

                $cuaHang = CuaHang::where('id', '=', Session('Cart')->deliveryMethod['cuaHangId'])->first();
                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => $cuaHang->dia_chi,
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 2,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 1,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . $cuaHang->dia_chi . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            }
        } else if ($request->phuongThuc == 3) {
            if (Session('Cart')->deliveryMethod['cachThucNhan'] == 1) {
                $kho = Kho::where('id', '!=', 1)->first();
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($chiTietKho != null) {
                        if ($chiTietKho->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong kho ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $chiTietKho->fill([
                        'so_luong' => $chiTietKho->so_luong - $tp['quantity'],
                    ]);
                    // $chiTietKho->so_luong = $chiTietKho->so_luong - $tp['quantity'];
                    $chiTietKho->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }

                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 3,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 1,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . Session('Cart')->infoUser['diaChi'] . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            } else {
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($sPPB != null) {
                        if ($sPPB->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong cửa hàng ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $sPPB->fill([
                        'so_luong' => $sPPB->so_luong - $tp['quantity'],
                    ]);
                    $sPPB->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }

                $cuaHang = CuaHang::where('id', '=', Session('Cart')->deliveryMethod['cuaHangId'])->first();
                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => $cuaHang->dia_chi,
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 3,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 1,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . $cuaHang->dia_chi . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            }
        } else if ($request->phuongThuc == 4) {
            if (Session('Cart')->deliveryMethod['cachThucNhan'] == 1) {
                $kho = Kho::where('id', '!=', 1)->first();
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($chiTietKho != null) {
                        if ($chiTietKho->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong kho ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong kho
                foreach (Session('Cart')->products as $tp) {
                    $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $chiTietKho->fill([
                        'so_luong' => $chiTietKho->so_luong - $tp['quantity'],
                    ]);
                    // $chiTietKho->so_luong = $chiTietKho->so_luong - $tp['quantity'];
                    $chiTietKho->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }

                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 4,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 1,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . Session('Cart')->infoUser['diaChi'] . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            } else {
                $output = '';
                $msg = '';
                $flag = 1;
                //Kiểm tra số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->select('so_luong')
                        ->first();
                    if ($sPPB != null) {
                        if ($sPPB->so_luong < $tp['quantity']) {
                            $flag = 0;
                            $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                                ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                                ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                                ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                                ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                                ->first();
                            $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                        }
                    } else {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                }
                if ($flag == 0) {
                    return response()->json(
                        $msg .= ' không đủ số lượng sản phẩm trong cửa hàng ! Mong quý khách thông cảm !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
                //Trừ số lượng sản phẩm trong cửa hàng
                foreach (Session('Cart')->products as $tp) {
                    $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                        ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                        ->first();
                    $sPPB->fill([
                        'so_luong' => $sPPB->so_luong - $tp['quantity'],
                    ]);
                    $sPPB->save();
                }
                $temp = null;
                if (Session('Cart')->voucher != null) {
                    $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
                }
                $phanTramGiamVoucher = 0;
                $idPhieuGiamGia = null;
                if ($temp != null) {
                    $phanTramGiamVoucher = $temp->phan_tram_giam;
                    $idPhieuGiamGia = $temp->id;
                    $temp->fill([
                        'trang_thai' => 0,
                    ]);
                    $temp->save();
                }

                $cuaHang = CuaHang::where('id', '=', Session('Cart')->deliveryMethod['cuaHangId'])->first();
                //Tạo đơn hàng
                $donHang = new DonHang();
                $donHang->fill([
                    'ma_don_hang' => 'DH' . Str::random(6) . str_replace('-', '', Carbon::now('Asia/Ho_Chi_Minh')->toDateString()),
                    'tai_khoan_khach_hang_id' => Auth::user()->id,
                    'tai_khoan_nhan_vien_id' => null,
                    'phieu_giam_gia_id' => $idPhieuGiamGia,
                    'cua_hang_id' => Session('Cart')->deliveryMethod['cuaHangId'],
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan_hang' => $cuaHang->dia_chi,
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'ghi_chu' => Session('Cart')->deliveryMethod['ghiChu'],
                    'phuong_thuc_nhan_hang' => Session('Cart')->deliveryMethod['cachThucNhan'],
                    'phuong_thuc_thanh_toan' => 4,
                    'ngay_giao' => null,
                    'trang_thai_thanh_toan' => 1,
                    'trang_thai_don_hang' => 0,
                    'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                $donHang->save();
                //Tạo chi tiết đơn hàng
                $tongTien = 0;
                foreach (Session('Cart')->products as $tp) {
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->fill([
                        'don_hang_id' => $donHang->ma_don_hang,
                        'chi_tiet_dien_thoai_id' => $tp['productInfo']->id,
                        'gia' => $tp['productInfo']->gia,
                        'gia_giam' => $tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher),
                        'so_luong' => $tp['quantity'],
                    ]);
                    $chiTietDonHang->save();
                    $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
                }

                $gioiTinh = 'Anh';
                if (Session('Cart')->infoUser['gioiTinh'] == 0) {
                    $gioiTinh = 'Chị';
                }
                $output .= '<div class="alertsuccess-new"><i class="new-cartnew-success"></i><strong>Đặt hàng thành công</strong></div>
                <div class="ordercontent">
                    <p>Cảm ơn ' . $gioiTinh . ' <b>' . Session('Cart')->infoUser['hoTen'] . '</b> đã cho T&T Mobile cơ hội được phục vụ.</p>
                    <div>
                        <div class="info-order" style="">
                            <div class="info-order-header">
                                <h4>Đơn hàng: <span>' . $donHang->ma_don_hang . '</span></h4>
                                <div class="header-right"><a href="/ordermanagement">Quản lý đơn hàng</a>
                                </div>
                            </div><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Người nhận hàng: </strong>Anh ' . Session('Cart')->infoUser['hoTen'] . ', ' . Session('Cart')->infoUser['sdt'] . '</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Nhận hàng tại địa chỉ: </strong>' . $cuaHang->dia_chi . '.</span>
                                </span></label><label><span class=""><i
                                        class="info-order__dot-icon"></i><span><strong>Tổng tiền: </strong><b
                                            class="red">' . number_format($tongTien, 0, ',', '.') . '₫</b></span>
                                </span></label>
                        </div>
                    </div>
                    <!---->
                </div>
                <div class="cartempty" style="margin-top: 0;padding-bottom: 10px;"><a href="/" class="backhome" style="width: 30%;position: relative;left: 34%;">Về trang chủ</a>
                </div>
                ';
                $details = [
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'ho_ten_nguoi_nhan' => Session('Cart')->infoUser['hoTen'],
                    'dia_chi_nhan' => Session('Cart')->infoUser['diaChi'],
                    'so_dien_thoai_nguoi_nhan' => Session('Cart')->infoUser['sdt'],
                    'tong_tien' => $tongTien,
                ];
                $thongTinTaiKhoan = ThongTinTaiKhoan::where('tai_khoan_id', '=', Auth::user()->id)->first();
                Mail::to($thongTinTaiKhoan->email)->send(new OrderMail($details));
                session()->forget('Cart');
                return response()->json($output);
            }
        }
    }
    public function kiemTraSoLuong()
    {
        if (Session('Cart')->voucher != null) {
            $kiemTraVoucher = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
            if ($kiemTraVoucher != null) {
                if ($kiemTraVoucher->trang_thai == 0) {
                    return response()->json(
                        'Phiếu giảm giá đã được sử dụng cho đơn hàng khác !',
                        404,
                        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                        JSON_UNESCAPED_UNICODE
                    );
                }
            }
        }

        if (Session('Cart')->deliveryMethod['cachThucNhan'] == 1) {
            $kho = Kho::where('id', '!=', 1)->first();
            $msg = '';
            $flag = 1;
            //Kiểm tra số lượng sản phẩm trong kho
            foreach (Session('Cart')->products as $tp) {
                $chiTietKho = ChiTietKho::where('kho_id', '=', $kho->id)
                    ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                    ->select('so_luong')
                    ->first();
                if ($chiTietKho != null) {
                    if ($chiTietKho->so_luong < $tp['quantity']) {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                } else {
                    $flag = 0;
                    $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                        ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                        ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                        ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                        ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                        ->first();
                    $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                }
            }
            if ($flag == 0) {
                return response()->json(
                    $msg .= ' không đủ số lượng sản phẩm trong kho ! Mong quý khách thông cảm !',
                    404,
                    ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            $msg = '';
            $flag = 1;
            //Kiểm tra số lượng sản phẩm trong cửa hàng
            foreach (Session('Cart')->products as $tp) {
                $sPPB = SanPhamPhanBo::where('cua_hang_id', '=', Session('Cart')->deliveryMethod['cuaHangId'])
                    ->where('chi_tiet_dien_thoai_id', '=', $tp['productInfo']->id)
                    ->select('so_luong')
                    ->first();
                if ($sPPB != null) {
                    if ($sPPB->so_luong < $tp['quantity']) {
                        $flag = 0;
                        $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                            ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                            ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                            ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                            ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                            ->first();
                        $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                    }
                } else {
                    $flag = 0;
                    $chiTietDienThoai = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                        ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                        ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                        ->where('chi_tiet_dien_thoais.id', '=', $tp['productInfo']->id)
                        ->select('chi_tiet_dien_thoais.*', 'bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                        ->first();
                    $msg .= $chiTietDienThoai->ten_san_pham . ' ' . $chiTietDienThoai->ram . '/' . $chiTietDienThoai->bo_nho_trong . ' - ' . $chiTietDienThoai->ten_mau_sac . ', ';
                }
            }
            if ($flag == 0) {
                return response()->json(
                    $msg .= ' không đủ số lượng sản phẩm trong cửa hàng ! Mong quý khách thông cảm !',
                    404,
                    ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }
        return response()->json('ok');
    }

    public function vnpay_payment()
    {
        $temp = null;
        if (Session('Cart')->voucher != null) {
            $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
        }
        $phanTramGiamVoucher = 0;
        if ($temp != null) {
            $phanTramGiamVoucher = $temp->phan_tram_giam;
        }
        $tongTien = 0;
        foreach (Session('Cart')->products as $tp) {
            $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
        }
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/confirm";
        $vnp_TmnCode = "G824EQGF"; //Mã website tại VNPAY
        $vnp_HashSecret = "HONPEPOZJXZXRFDPVHFMKDANGIEZKGPX"; //Chuỗi bí mật

        $vnp_TxnRef = Str::random(6); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $tongTien * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment()
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $temp = null;
        if (Session('Cart')->voucher != null) {
            $temp = PhieuGiamGia::where('code', '=', Session('Cart')->voucher['code'])->first();
        }
        $phanTramGiamVoucher = 0;
        if ($temp != null) {
            $phanTramGiamVoucher = $temp->phan_tram_giam;
        }
        $tongTien = 0;
        foreach (Session('Cart')->products as $tp) {
            $tongTien += $tp['quantity'] * ($tp['productInfo']->gia - $tp['productInfo']->gia * ($tp['productInfo']->phan_tram_giam + $phanTramGiamVoucher));
        }

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $tongTien;
        $orderId = time() . "";
        $redirectUrl = "http://localhost:8000/confirm";
        $ipnUrl = "http://localhost:8000/confirm";
        $extraData = "merchantName=MoMo Partner";

        $requestId = time() . "";
        // $requestType = "payWithATM";
        $requestType = "captureWallet";

        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);
        // header('Location: ' . $jsonResult['payUrl']);
    }
}
