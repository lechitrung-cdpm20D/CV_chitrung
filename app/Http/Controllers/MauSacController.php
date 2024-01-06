<?php

namespace App\Http\Controllers;

use App\Models\MauSac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MauSacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachMau = MauSac::All();
        return view('admin/management-page/color', ['danhSachMau' => $danhSachMau]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-color');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMauSacRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenmausac' => 'required|max:30',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
            ],
            [
                'tenmausac' => 'Tên màu sắc',
            ]
        )->validate();

        //Định dạng lại tên màu
        $mauFormat=trim( $request->input('tenmausac'));
        $tontai = MauSac::where('ten_mau_sac', 'like', $mauFormat)->first();
        if (empty($tontai)) {
            $kTTenMau = str_replace(' ', '', $mauFormat);
            $tontai = MauSac::where('ten_mau_sac', 'like', $kTTenMau)->first();
            if (empty($tontai)) {
                $mauSac = new MauSac;
                $mauSac->fill([
                    'ten_mau_sac' => $mauFormat,
                ]);
                if ($mauSac->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm màu sắc thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm màu sắc không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm màu sắc không thành công ! Màu sắc đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MauSac  $mauSac
     * @return \Illuminate\Http\Response
     */
    public function show(MauSac $mauSac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MauSac  $mauSac
     * @return \Illuminate\Http\Response
     */
    public function edit(MauSac $mauSac)
    {
        return view('admin/edit-page/edit-color', ['mauSac' => $mauSac]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMauSacRequest  $request
     * @param  \App\Models\MauSac  $mauSac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MauSac $mauSac)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenmausac' => 'required|max:30',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
            ],
            [
                'tenmausac' => 'Tên màu sắc',
            ]
        )->validate();

        //Định dạng lại tên màu
        $mauFormat=trim( $request->input('tenmausac'));
        $tontai = MauSac::where('ten_mau_sac', 'like', $mauFormat)->where('id','!=',$mauSac->id)->first();
        if (empty($tontai)) {
            $kTTenMau = str_replace(' ', '', $mauFormat);
            $tontai = MauSac::where('ten_mau_sac', 'like', $kTTenMau)->where('id','!=',$mauSac->id)->first();
            if (empty($tontai)) {
                $mauSac->fill([
                    'ten_mau_sac' => $mauFormat,
                ]);
                if ($mauSac->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật màu sắc thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật màu sắc không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật màu sắc không thành công ! Màu sắc đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MauSac  $mauSac
     * @return \Illuminate\Http\Response
     */
    public function destroy(MauSac $mauSac)
    {
        if ($mauSac->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa màu sắc thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa màu sắc không thành công !');
    }
}
