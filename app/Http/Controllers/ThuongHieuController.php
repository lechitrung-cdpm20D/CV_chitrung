<?php

namespace App\Http\Controllers;

use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThuongHieuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachThuongHieu = ThuongHieu::all();
        return view('admin/management-page/brand', ['danhSachThuongHieu' => $danhSachThuongHieu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-brand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreThuongHieuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenthuonghieu' => 'required|max:30',
                'hinhanh' => 'mimes:jpeg,jpg,png',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !'
            ],
            [
                'tenthuonghieu' => 'Tên thương hiệu',
                'hinhanh' => 'Hình ảnh',
            ]
        )->validate();

        //Định dạng lại tên thương hiệu
        $thuongHieuFormat = trim($request->input('tenthuonghieu'));
        $tontai = ThuongHieu::where('ten_thuong_hieu', 'like', $thuongHieuFormat)->first();
        if (empty($tontai)) {
            $kTTenThuongHieu = str_replace(' ', '', $thuongHieuFormat);
            $tontai = ThuongHieu::where('ten_thuong_hieu', 'like', $kTTenThuongHieu)->first();
            if (empty($tontai)) {
                $thuongHieu = new ThuongHieu();
                $thuongHieu->fill([
                    'ten_thuong_hieu' => $request->input('tenthuonghieu'),
                    'hinh_anh' => '',
                ]);
                if ($request->hasFile('hinhanh')) {
                    $request->file('hinhanh')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu, $request->file('hinhanh')->getClientOriginalName());
                    $thuongHieu->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $request->file('hinhanh')->getClientOriginalName();
                } else {
                    $thuongHieu->hinh_anh = 'default/default.png';
                }

                if ($thuongHieu->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm thương hiệu thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm thương hiệu không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm thương hiệu không thành công ! Tên thương hiệu đã tồn tại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function show(ThuongHieu $thuongHieu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function edit(ThuongHieu $thuongHieu)
    {
        return view('admin/edit-page/edit-brand', ['thuongHieu' => $thuongHieu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateThuongHieuRequest  $request
     * @param  \App\Models\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThuongHieu $thuongHieu)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenthuonghieu' => 'required|max:30',
                'hinhanh' => 'mimes:jpeg,jpg,png',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
                'mimes' => ':attribute phải có thuộc tính là jpeg, jpg, png !'
            ],
            [
                'tenthuonghieu' => 'Tên thương hiệu',
                'hinhanh' => 'Hình ảnh',
            ]
        )->validate();

        //Định dạng lại tên thương hiệu
        $thuongHieuFormat = trim($request->input('tenthuonghieu'));
        $tontai = ThuongHieu::where('ten_thuong_hieu', 'like', $thuongHieuFormat)->where('id','!=',$thuongHieu->id)->first();
        if (empty($tontai)) {
            $kTTenThuongHieu = str_replace(' ', '', $thuongHieuFormat);
            $tontai = ThuongHieu::where('ten_thuong_hieu', 'like', $kTTenThuongHieu)->where('id','!=',$thuongHieu->id)->first();
            if (empty($tontai)) {
                $thuongHieu->fill([
                    'ten_thuong_hieu' => $request->input('tenthuonghieu'),
                ]);
                if ($request->hasFile('hinhanh')) {
                    $request->file('hinhanh')->storeAs('public/images/' . $thuongHieu->ten_thuong_hieu, $request->file('hinhanh')->getClientOriginalName());
                    $thuongHieu->hinh_anh = $thuongHieu->ten_thuong_hieu . '/' . $request->file('hinhanh')->getClientOriginalName();
                }

                if ($thuongHieu->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật thương hiệu thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật thương hiệu không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật thương hiệu không thành công ! Tên thương hiệu đã tồn tại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThuongHieu $thuongHieu)
    {
        if ($thuongHieu->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa thương hiệu thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa thương hiệu không thành công !');
    }
}
