<?php

namespace App\Http\Controllers;

use App\Models\HinhAnhChungCuaDienThoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DienThoai;
use App\Models\ThuongHieu;

class HinhAnhChungCuaDienThoaiController extends Controller
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
     * @param  \App\Http\Requests\StoreHinhAnhChungCuaDienThoaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HinhAnhChungCuaDienThoai  $hinhAnhChungCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function show(HinhAnhChungCuaDienThoai $hinhAnhChungCuaDienThoai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HinhAnhChungCuaDienThoai  $hinhAnhChungCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function edit(HinhAnhChungCuaDienThoai $hinhAnhChungCuaDienThoai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHinhAnhChungCuaDienThoaiRequest  $request
     * @param  \App\Models\HinhAnhChungCuaDienThoai  $hinhAnhChungCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HinhAnhChungCuaDienThoai $hinhAnhChungCuaDienThoai)
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
                'hinhanh' => 'Hình ảnh',
            ]
        )->validate();

        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        //Lấy tên thương hiệu
        $thuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
            ->select('ten_thuong_hieu')
            ->first();

        //Cập nhật ảnh nổi bật
        if ($hinhAnhChungCuaDienThoai->loai_hinh == 3) {
            if ($request->hasFile('hinhanh')) {
                $request->file('hinhanh')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhNoiBat', $request->file('hinhanh')->getClientOriginalName());
                $hinhAnhChungCuaDienThoai->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhNoiBat/' . $request->file('hinhanh')->getClientOriginalName();
            }
            if ($hinhAnhChungCuaDienThoai->save() == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh không thành công !');
        }

        //Cập nhật ảnh 360
        if ($hinhAnhChungCuaDienThoai->loai_hinh == 4) {
            if ($request->hasFile('hinhanh')) {
                $request->file('hinhanh')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnh360', $request->file('hinhanh')->getClientOriginalName());
                $hinhAnhChungCuaDienThoai->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnh360/' . $request->file('hinhanh')->getClientOriginalName();
            }
            if ($hinhAnhChungCuaDienThoai->save() == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh không thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật hình ảnh không thành công ! Loại hình không đúng với dữ liệu hệ thống!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HinhAnhChungCuaDienThoai  $hinhAnhChungCuaDienThoai
     * @return \Illuminate\Http\Response
     */
    public function destroy(HinhAnhChungCuaDienThoai $hinhAnhChungCuaDienThoai)
    {
        if ($hinhAnhChungCuaDienThoai->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa hình ảnh thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa hình ảnh không thành công !');
    }

    public function indexHinhAnhNoiBat($sanPhamId)
    {
        $danhSachHinhAnhNoiBat = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('loai_hinh', '=', 3)
            ->get();
        $dienThoai = DienThoai::where('id', '=', $sanPhamId)
            ->first();
        return view('admin/management-page/featuredpicture', ['danhSachHinhAnhNoiBat' => $danhSachHinhAnhNoiBat, 'dienThoai' => $dienThoai]);
    }

    public function storeHinhAnhNoiBat(Request $request)
    {
        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'hinhanhnoibat' => 'mimes:jpeg,jpg,png',
            ],
            $messages = [
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !',
            ],
            [
                'hinhanhnoibat' => 'Hình ảnh nổi bật',
            ]
        )->validate();

        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        //Lấy tên thương hiệu
        $thuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
            ->select('ten_thuong_hieu')
            ->first();

        $hinhAnhNoiBat = new HinhAnhChungCuaDienThoai();
        $hinhAnhNoiBat->fill([
            'dien_thoai_id' => $dienThoai->id,
            'hinh_anh' => '',
            'loai_hinh' => 3, //Hình nổi bật
        ]);
        if ($request->hasFile('hinhanhnoibat')) {
            $request->file('hinhanhnoibat')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhNoiBat', $request->file('hinhanhnoibat')->getClientOriginalName());
            $hinhAnhNoiBat->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnhNoiBat/' . $request->file('hinhanhnoibat')->getClientOriginalName();
        } else {
            $hinhAnhNoiBat->hinh_anh = 'default/default.png';
        }
        if ($hinhAnhNoiBat->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm hình ảnh nổi bật thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm hình ảnh nổi bật không thành công !');
    }

    public function indexHinhAnh360($sanPhamId)
    {
        $danhSachHinhAnh360 = HinhAnhChungCuaDienThoai::where('dien_thoai_id', '=', $sanPhamId)
            ->where('loai_hinh', '=', 4)
            ->get();
        $dienThoai = DienThoai::where('id', '=', $sanPhamId)
            ->first();
        return view('admin/management-page/360picture', ['danhSachHinhAnh360' => $danhSachHinhAnh360, 'dienThoai' => $dienThoai]);
    }

    public function storeHinhAnh360(Request $request)
    {
        //Kiểm tra thông tin các trường nhập vào
        $validated = Validator::make(
            $request->all(),
            [
                'hinhanh360' => 'mimes:jpeg,jpg,png',
            ],
            $messages = [
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !',
            ],
            [
                'hinhanh360' => 'Hình ảnh 360',
            ]
        )->validate();

        $dienThoai = DienThoai::where('id', '=', $request->input('dienthoaiid'))
            ->first();
        if (empty($dienThoai)) {
            return abort(404);
        }
        //Lấy tên thương hiệu
        $thuongHieu = ThuongHieu::where('id', '=', $dienThoai->thuong_hieu_id)
            ->select('ten_thuong_hieu')
            ->first();

        $hinhAnh360 = new HinhAnhChungCuaDienThoai();
        $hinhAnh360->fill([
            'dien_thoai_id' => $dienThoai->id,
            'hinh_anh' => '',
            'loai_hinh' => 4, //Hình 360
        ]);
        if ($request->hasFile('hinhanh360')) {
            $request->file('hinhanh360')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnh360', $request->file('hinhanh360')->getClientOriginalName());
            $hinhAnh360->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $dienThoai->ten_san_pham . '/HinhAnh360/' . $request->file('hinhanh360')->getClientOriginalName();
        } else {
            $hinhAnh360->hinh_anh = 'default/default.png';
        }
        if ($hinhAnh360->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm hình ảnh 360 thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm hình ảnh 360 không thành công !');
    }
}
