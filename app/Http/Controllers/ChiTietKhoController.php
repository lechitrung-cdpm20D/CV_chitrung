<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDienThoai;
use App\Models\ChiTietKho;
use App\Models\Kho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ChiTietKhoController extends Controller
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
     * @param  \App\Http\Requests\StoreChiTietKhoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'soluong' => 'required|integer|min:0|numeric',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
                'integer' => ':attribute phải là kiểu số nguyên!',
            ],
            [
                'soluong' => 'Số lượng',
            ]
        )->validate();

        if (empty($request->sanpham)) {
            return redirect()->back()->with('thongbao', 'Chưa chọn sản phẩm để thêm vào kho !');
        } else {
            $danhSachSanPhamChon = $request->sanpham;
            $flag = 1;
            //Biến lưu tên sản phẩm lỗi
            $tenSanPham = '';
            foreach ($danhSachSanPhamChon as $tp) {
                //Kiểm tra sản phẩm có nằm trong kho
                $chiTietKho = ChiTietKho::where('chi_tiet_dien_thoai_id', '=', $tp)->first();
                if (!empty($chiTietKho)) {
                    $flag = 0;
                    $temp = ChiTietDienThoai::join('mau_sacs', 'mau_sacs.id', '=', 'chi_tiet_dien_thoais.mau_sac_id')
                        ->join('bo_nho_luu_trus', 'bo_nho_luu_trus.id', '=', 'chi_tiet_dien_thoais.bo_nho_luu_tru_id')
                        ->join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_dien_thoais.dien_thoai_id')
                        ->where('chi_tiet_dien_thoais.id', '=', $chiTietKho->id)
                        ->select('bo_nho_luu_trus.ram', 'bo_nho_luu_trus.bo_nho_trong', 'mau_sacs.ten_mau_sac', 'dien_thoais.ten_san_pham')
                        ->first();
                    $tenSanPham = $tenSanPham . $temp->ten_san_pham.' - '.$temp->ram.'/'.$temp->bo_nho_trong.' - '.$temp->ten_mau_sac. ', ';
                }
            }
            if ($flag == 1) {
                $ngayNhap = Carbon::now('Asia/Ho_Chi_Minh');
                foreach ($danhSachSanPhamChon as $tp) {
                    $chiTietKho = new ChiTietKho();
                    $chiTietKho->fill([
                        'kho_id' => $request->input('khoid'),
                        'so_luong' => $request->input('soluong'),
                        'chi_tiet_dien_thoai_id' => $tp,
                        'ngay_nhap'=> $ngayNhap,
                    ]);
                    $chiTietKho->save();
                }
                return redirect()->back()->with('thongbao', 'Thêm chi tiết kho thành công !');
            }
            return redirect()->back()->with('thongbao', 'Sản phẩm ' . $tenSanPham . 'sản phẩm đã tồn tại trong kho ! Thêm chi tiết kho không thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm chi tiết kho không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChiTietKho  $chiTietKho
     * @return \Illuminate\Http\Response
     */
    public function show(ChiTietKho $chiTietKho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChiTietKho  $chiTietKho
     * @return \Illuminate\Http\Response
     */
    public function edit(ChiTietKho $chiTietKho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChiTietKhoRequest  $request
     * @param  \App\Models\ChiTietKho  $chiTietKho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChiTietKho $chiTietKho)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'soluong' => 'required|integer|min:0|numeric',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
                'integer' => ':attribute phải là kiểu số nguyên!',
            ],
            [
                'soluong' => 'Số lượng',
            ]
        )->validate();

        $chiTietKho->fill([
            'so_luong' => $request->input('soluong'),
        ]);
        if($chiTietKho->save() == true){
            return redirect()->back()->with('thongbao', 'Cập nhật chi tiết kho thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật chi tiết kho không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChiTietKho  $chiTietKho
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChiTietKho $chiTietKho)
    {
        if ($chiTietKho->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa chi tiết kho thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa chi tiết kho không thành công !');
    }
}
