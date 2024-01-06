<?php

namespace App\Http\Controllers;

use App\Models\ChiTietKhuyenMai;
use App\Models\DienThoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChiTietKhuyenMaiController extends Controller
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
     * @param  \App\Http\Requests\StoreChiTietKhuyenMaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'phantramgiam' => 'required|max:1|min:0|numeric',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute tối đa là 1 !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
            ],
            [
                'phantramgiam' => 'Phần trăm giảm',
            ]
        )->validate();
        if (empty($request->sanpham)) {
            return redirect()->back()->with('thongbao', 'Chưa chọn sản phẩm để khuyến mãi !');
        } else {
            $danhSachSanPhamChon = $request->sanpham;
            $flag = 1;
            //Biến lưu tên sản phẩm lỗi
            $tenSanPhamLoi = '';
            foreach ($danhSachSanPhamChon as $tp) {
                //Kiểm tra sản phẩm có nằm trong khuyến mãi
                $kTTonTai = ChiTietKhuyenMai::where('dien_thoai_id', '=', $tp)->first();
                if (!empty($kTTonTai)) {
                    $flag = 0;
                    $tenSanPhamLoi = $tenSanPhamLoi.DienThoai::where('id','=',$tp)->select('ten_san_pham')->first()->ten_san_pham.', ';
                }
            }
            if ($flag == 1) {
                foreach ($danhSachSanPhamChon as $tp) {
                    $chiTietKhuyenMai = new ChiTietKhuyenMai();
                    $chiTietKhuyenMai->fill([
                        'khuyen_mai_id' => $request->input('khuyenmaiid'),
                        'phan_tram_giam' => $request->input('phantramgiam'),
                        'dien_thoai_id' => $tp,
                    ]);
                    $chiTietKhuyenMai->save();
                }
                return redirect()->back()->with('thongbao', 'Thêm chi tiết khuyến mãi thành công !');
            }
            return redirect()->back()->with('thongbao', 'Sản phẩm '.$tenSanPhamLoi.'sản phẩm hiện đang nằm trong chương trình khuyến mãi ! Thêm chi tiết khuyến mãi không thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm chi tiết khuyến mãi không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChiTietKhuyenMai  $chiTietKhuyenMai
     * @return \Illuminate\Http\Response
     */
    public function show(ChiTietKhuyenMai $chiTietKhuyenMai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChiTietKhuyenMai  $chiTietKhuyenMai
     * @return \Illuminate\Http\Response
     */
    public function edit(ChiTietKhuyenMai $chiTietKhuyenMai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChiTietKhuyenMaiRequest  $request
     * @param  \App\Models\ChiTietKhuyenMai  $chiTietKhuyenMai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChiTietKhuyenMai $chiTietKhuyenMai)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'phantramgiam' => 'required|max:1|min:0|numeric',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute tối đa là 1 !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
            ],
            [
                'phantramgiam' => 'Phần trăm giảm',
            ]
        )->validate();

        $chiTietKhuyenMai->fill([
            'phan_tram_giam' => $request->input('phantramgiam'),
        ]);
        if($chiTietKhuyenMai->save() == true){
            return redirect()->back()->with('thongbao', 'Cập nhật chi tiết khuyến mãi thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật chi tiết khuyến mãi không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChiTietKhuyenMai  $chiTietKhuyenMai
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChiTietKhuyenMai $chiTietKhuyenMai)
    {
        if ($chiTietKhuyenMai->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa chi tiết khuyến mãi thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa chi tiết khuyến mãi không thành công !');
    }
}
