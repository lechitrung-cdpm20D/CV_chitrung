<?php

namespace App\Http\Controllers;

use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\DienThoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KhuyenMaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachKhuyenMai = KhuyenMai::all();
        foreach ($danhSachKhuyenMai as $tp) {
            $tp->ngay_bat_dau = Carbon::createFromFormat('Y-m-d', $tp->ngay_bat_dau)->format('d/m/Y');
            $tp->ngay_ket_thuc = Carbon::createFromFormat('Y-m-d', $tp->ngay_ket_thuc)->format('d/m/Y');
        }
        return view('admin/management-page/promotion', ['danhSachKhuyenMai' => $danhSachKhuyenMai]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-promotion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKhuyenMaiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenkhuyenmai' => 'required|max:100',
                'ngaybatdau' => 'required|date|after_or_equal: today',
                'ngayketthuc' => 'required|date|after:ngaybatdau',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute tối đa 100 ký tự !',
                'after_or_equal' => ':attribute phải bằng hoặc sau ngày hôm nay !',
                'after' => ':attribute phải sau ngày bắt đầu !',
                'date' => ':attribute không đúng kiểu dữ liệu !',
            ],
            [
                'tenkhuyenmai' => 'Tên khuyến mãi',
                'ngaybatdau' => 'Ngày bắt đầu',
                'ngayketthuc' => 'Ngày kết thúc',
            ]
        )->validate();

        //Định dạng lại tên tên khuyến mãi
        $khuyenMaiFormat = trim($request->input('tenkhuyenmai'));
        $tontai = KhuyenMai::Where('ten_khuyen_mai', '=', $khuyenMaiFormat)->first();
        if (empty($tontai)) {
            $kTTenKhuyenMai = str_replace(' ', '', $khuyenMaiFormat);
            $tontai = KhuyenMai::where('ten_khuyen_mai', 'like', $kTTenKhuyenMai)->first();
            if (empty($tontai)) {
                $khuyenMai = new KhuyenMai();
                $khuyenMai->fill([
                    'ten_khuyen_mai' => $khuyenMaiFormat,
                    'ngay_bat_dau' => $request->input('ngaybatdau'),
                    'ngay_ket_thuc' => $request->input('ngayketthuc'),
                ]);
                if ($khuyenMai->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm khuyến mãi thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm khuyến mãi không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm khuyến mãi không thành công ! Tên khuyến mãi đã tồn tại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KhuyenMai  $khuyenMai
     * @return \Illuminate\Http\Response
     */
    public function show(KhuyenMai $khuyenMai)
    {
        $danhSachChiTietKhuyenMai = ChiTietKhuyenMai::join('dien_thoais', 'dien_thoais.id', '=', 'chi_tiet_khuyen_mais.dien_thoai_id')
            ->join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->where('khuyen_mai_id', '=', $khuyenMai->id)
            ->select('chi_tiet_khuyen_mais.*', 'dien_thoais.ten_san_pham', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        $danhSachSanPham = DienThoai::join('thuong_hieus', 'thuong_hieus.id', '=', 'dien_thoais.thuong_hieu_id')
            ->select('dien_thoais.*', 'thuong_hieus.ten_thuong_hieu')
            ->get();
        return view('admin/management-page/detail-promotion', ['khuyenMai' => $khuyenMai, 'danhSachChiTietKhuyenMai' => $danhSachChiTietKhuyenMai, 'danhSachSanPham' => $danhSachSanPham]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KhuyenMai  $khuyenMai
     * @return \Illuminate\Http\Response
     */
    public function edit(KhuyenMai $khuyenMai)
    {
        return view('admin/edit-page/edit-promotion', ['khuyenMai' => $khuyenMai]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKhuyenMaiRequest  $request
     * @param  \App\Models\KhuyenMai  $khuyenMai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KhuyenMai $khuyenMai)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenkhuyenmai' => 'required|max:100',
                'ngayketthuc' => 'required|date|after:ngaybatdau',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute tối đa 100 ký tự !',
                'date' => ':attribute không đúng kiểu dữ liệu !',
                'after' => ':attribute phải sau ngày bắt đầu !'
            ],
            [
                'tenkhuyenmai' => 'Tên khuyến mãi',
                'ngayketthuc' => 'Ngày kết thúc',
            ]
        )->validate();

        //Định dạng lại tên khuyến mãi
        $khuyenMaiFormat = trim($request->input('tenkhuyenmai'));
        $tontai = KhuyenMai::Where('ten_khuyen_mai', '=', $khuyenMaiFormat)->where('id', '!=', $khuyenMai->id)->first();
        if (empty($tontai)) {
            $kTTenKhuyenMai = str_replace(' ', '', $khuyenMaiFormat);
            $tontai = KhuyenMai::where('ten_khuyen_mai', 'like', $kTTenKhuyenMai)->where('id', '!=', $khuyenMai->id)->first();
            if (empty($tontai)) {
                $khuyenMai->fill([
                    'ten_khuyen_mai' => $khuyenMaiFormat,
                    'ngay_ket_thuc' => $request->input('ngayketthuc'),
                ]);
                if ($khuyenMai->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật khuyến mãi thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật khuyến mãi không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật khuyến mãi không thành công ! Tên khuyến mãi đã tồn tại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KhuyenMai  $khuyenMai
     * @return \Illuminate\Http\Response
     */
    public function destroy(KhuyenMai $khuyenMai)
    {
        if ($khuyenMai->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa khuyến mãi thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa khuyến mãi không thành công !');
    }
}
