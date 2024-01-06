<?php

namespace App\Http\Controllers;

use App\Models\PhieuGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;


class PhieuGiamGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachPhieuGiamGia = PhieuGiamGia::all();
        foreach ($danhSachPhieuGiamGia as $tp) {
            $tp->ngay_bat_dau = Carbon::createFromFormat('Y-m-d', $tp->ngay_bat_dau)->format('d/m/Y');
            $tp->ngay_het_han = Carbon::createFromFormat('Y-m-d', $tp->ngay_het_han)->format('d/m/Y');
        }
        return view('admin/management-page/voucher', ['danhSachPhieuGiamGia' => $danhSachPhieuGiamGia]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-voucher');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhieuGiamGiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'phantramgiam' => 'required|max:1|min:0|numeric',
                'ngaybatdau' => 'required|date|after_or_equal: today',
                'ngayhethan' => 'required|date|after:ngaybatdau',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số!',
                'after_or_equal' => ':attribute phải bằng hoặc sau ngày hôm nay !',
                'after' => ':attribute phải sau ngày bắt đầu !',
                'max' => ':attribute tối đa là 1 !',
                'min' => ':attribute tối thiểu là 0 !',
                'date' => ':attribute không đúng kiểu dữ liệu !',
            ],
            [
                'phantramgiam' => 'Phần trăm giảm',
                'ngaybatdau' => 'Ngày bắt đầu',
                'ngayhethan' => 'Ngày hết hạn',
            ]
        )->validate();

        $phieuGiamGia = new PhieuGiamGia();
        $phieuGiamGia->fill([
            'code' => Str::random(8),
            'phan_tram_giam' => $request->input('phantramgiam'),
            'ngay_bat_dau' => $request->input('ngaybatdau'),
            'ngay_het_han' => $request->input('ngayhethan'),
            'trang_thai' => 1,
        ]);
        if ($phieuGiamGia->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm phiếu giảm giá thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm phiếu giảm giá không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhieuGiamGia  $phieuGiamGia
     * @return \Illuminate\Http\Response
     */
    public function show(PhieuGiamGia $phieuGiamGia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhieuGiamGia  $phieuGiamGia
     * @return \Illuminate\Http\Response
     */
    public function edit(PhieuGiamGia $phieuGiamGium)
    {
        return view('admin/edit-page/edit-voucher', ['phieuGiamGium' => $phieuGiamGium]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhieuGiamGiaRequest  $request
     * @param  \App\Models\PhieuGiamGia  $phieuGiamGia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhieuGiamGia $phieuGiamGium)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'phantramgiam' => 'required|max:1|min:0|numeric',
                'ngayhethan' => 'required|date|after:ngaybatdau',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số!',
                'after_or_equal' => ':attribute phải bằng hoặc sau ngày hôm nay !',
                'after' => ':attribute phải sau ngày bắt đầu !',
                'max' => ':attribute tối đa là 1 !',
                'min' => ':attribute tối thiểu là 0 !',
                'date' => ':attribute không đúng kiểu dữ liệu !',
            ],
            [
                'phantramgiam' => 'Phần trăm giảm',
                'ngaybatdau' => 'Ngày bắt đầu',
                'ngayhethan' => 'Ngày hết hạn',
            ]
        )->validate();

        $phieuGiamGium->fill([
            'phan_tram_giam' => $request->input('phantramgiam'),
            'ngay_het_han' => $request->input('ngayhethan'),
        ]);
        if ($phieuGiamGium->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật phiếu giảm giá thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật phiếu giảm giá không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuGiamGia  $phieuGiamGia
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuGiamGia $phieuGiamGium)
    {
        if ($phieuGiamGium->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa phiếu giảm giá thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa phiếu giảm giá không thành công !');
    }
}
