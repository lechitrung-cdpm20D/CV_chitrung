<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDienThoai;
use App\Models\ThuongHieu;
use App\Models\HinhAnhMauSacCuaDienThoai;
use App\Models\DienThoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HinhAnhMauSacCuaDienThoaiController extends Controller
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

    public function indexHinhAnhMauSac($sanPhamId)
    {
        $danhSachHinhAnhMauSac = HinhAnhMauSacCuaDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'hinh_anh_mau_sac_cua_dien_thoais.mau_sac_id')
            ->where('dien_thoai_id', '=', $sanPhamId)
            ->select('hinh_anh_mau_sac_cua_dien_thoais.*', 'mau_sacs.ten_mau_sac')
            ->get();
        $dienThoai = DienThoai::where('id', '=', $sanPhamId)
            ->first();
        $danhSachMauSac = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
            ->where('dien_thoai_id', '=', $sanPhamId)
            ->select('chi_tiet_dien_thoais.mau_sac_id', 'mau_sacs.ten_mau_sac')
            ->groupBy('chi_tiet_dien_thoais.mau_sac_id', 'mau_sacs.ten_mau_sac')
            ->get();
        return view('admin/management-page/colorpicture', ['danhSachHinhAnhMauSac' => $danhSachHinhAnhMauSac, 'danhSachMauSac' => $danhSachMauSac, 'dienThoai' => $dienThoai]);
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
     * @param  \App\Http\Requests\StoreHinhAnhMauSacCuaDienThoaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'hinhanhmausac' => 'mimes:jpeg,jpg,png',
            ],
            $messages = [
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !',
            ],
            [
                'hinhanhmausac' => 'Hình ảnh màu sắc',
            ]
        )->validate();

        //Kiểm tra id điện thoại
        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        //Kiểm tra id màu sắc
        $mauSac = HinhAnhMauSacCuaDienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->where('mau_sac_id', '=', $request->input('mausacid'))
            ->get();
        if (empty($mauSac)) {
            return abort(404);
        }
        //Lấy tên thương hiệu
        $thuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
            ->select('ten_thuong_hieu')
            ->first();

        $hinhAnhMauSac = new HinhAnhMauSacCuaDienThoai();
        $hinhAnhMauSac->fill([
            'dien_thoai_id' => $dienThoai->id,
            'mau_sac_id' => $request->input('mausacid'),
            'hinh_anh_dai_dien' => 0,
            'hinh_anh' => '',
        ]);
        if ($request->hasFile('hinhanhmausac')) {
            $request->file('hinhanhmausac')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhMauSac', $request->file('hinhanhmausac')->getClientOriginalName());
            $hinhAnhMauSac->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhMauSac/' . $request->file('hinhanhmausac')->getClientOriginalName();
        } else {
            $hinhAnhMauSac->hinh_anh = 'default/default.png';
        }
        if ($hinhAnhMauSac->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm hình ảnh màu sắc thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm hình ảnh màu sắc không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HinhAnhMauSacCuaDienThoai  $hinhAnhMauSacCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function show(HinhAnhMauSacCuaDienThoai $hinhAnhMauSacCuaDienThoai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HinhAnhMauSacCuaDienThoai  $hinhAnhMauSacCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function edit(HinhAnhMauSacCuaDienThoai $hinhAnhMauSacCuaDienThoai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHinhAnhMauSacCuaDienThoaiRequest  $request
     * @param  \App\Models\HinhAnhMauSacCuaDienThoai  $hinhAnhMauSacCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HinhAnhMauSacCuaDienThoai $hinhAnhMauSacCuaDienThoai)
    {
        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'hinhanh' => 'mimes:jpeg,jpg,png',
            ],
            $messages = [
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !',
            ],
            [
                'hinhanh' => 'Hình ảnh màu sắc',
            ]
        )->validate();

        //Kiểm tra id điện thoại
        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        //Kiểm tra id màu sắc
        $mauSac = HinhAnhMauSacCuaDienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->where('mau_sac_id', '=', $request->input('mausacid'))
            ->get();
        if (empty($mauSac)) {
            return abort(404);
        }
        //Lấy tên thương hiệu
        $thuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
            ->select('ten_thuong_hieu')
            ->first();

        if ($hinhAnhMauSacCuaDienThoai->hinh_anh_dai_dien == 0) {
            $hinhAnhMauSacCuaDienThoai->fill([
                'mau_sac_id' => $request->input('mausacid'),
            ]);
        }
        if ($request->hasFile('hinhanh')) {
            $request->file('hinhanh')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhMauSac', $request->file('hinhanh')->getClientOriginalName());
            $hinhAnhMauSacCuaDienThoai->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhMauSac/' . $request->file('hinhanh')->getClientOriginalName();
        }
        if ($hinhAnhMauSacCuaDienThoai->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh màu sắc thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh màu sắc không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HinhAnhMauSacCuaDienThoai  $hinhAnhMauSacCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function destroy(HinhAnhMauSacCuaDienThoai $hinhAnhMauSacCuaDienThoai)
    {
        if ($hinhAnhMauSacCuaDienThoai->hinh_anh_dai_dien == 0) {
            if ($hinhAnhMauSacCuaDienThoai->delete()) {
                return redirect()->back()->with('thongbao', 'Xóa hình ảnh thành công !');
            }
            return redirect()->back()->with('thongbao', 'Xóa hình ảnh không thành công !');
        } else {
            $kTChiTietDienThoai = ChiTietDienThoai::where('mau_sac_id', '=', $hinhAnhMauSacCuaDienThoai->mau_sac_id)
                ->where('dien_thoai_id', '=', $hinhAnhMauSacCuaDienThoai->dien_thoai_id)
                ->first();
            if (empty($kTChiTietDienThoai)) {
                if ($hinhAnhMauSacCuaDienThoai->delete()) {
                    return redirect()->back()->with('thongbao', 'Xóa hình ảnh thành công !');
                }
                return redirect()->back()->with('thongbao', 'Xóa hình ảnh không thành công !');
            }
            return redirect()->back()->with('thongbao', 'Xóa hình ảnh không thành công ! Chi tiết sản phẩm có màu này còn tồn tại !');
        }
    }
}
