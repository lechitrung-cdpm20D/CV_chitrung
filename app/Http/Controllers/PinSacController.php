<?php

namespace App\Http\Controllers;

use App\Models\Pin_Sac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PinSacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachPinSac = Pin_Sac::All();
        return view('admin/management-page/pin', ['danhSachPinSac' => $danhSachPinSac]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-pin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePin_SacRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'dungluongpin' => 'required|max:500',
                'loaipin' => 'required|max:500',
                'hotrosactoida' => 'required|max:500',
                'sackemtheomay' => 'required|max:500',
                'congnghepin' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'dungluongpin' => 'Dung lượng pin',
                'loaipin' => 'Loại pin',
                'hotrosactoida' => 'Hỗ trợ sạc tối đa',
                'sackemtheomay' => 'Sạc kèm theo máy',
                'congnghepin' => 'Công nghệ pin',
            ]
        )->validate();

        $pin_Sac = new Pin_Sac();
        $pin_Sac->fill([
            'dung_luong_pin' => $request->input('dungluongpin'),
            'loai_pin' => $request->input('loaipin'),
            'ho_tro_sac_toi_da' => $request->input('hotrosactoida'),
            'sac_kem_theo_may' => $request->input('sackemtheomay'),
            'cong_nghe_pin' => $request->input('congnghepin'),
        ]);
        if ($pin_Sac->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm pin - sạc thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm pin - sạc không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pin_Sac  $pin_Sac
     * @return \Illuminate\Http\Response
     */
    public function show(Pin_Sac $pin_Sac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pin_Sac  $pin_Sac
     * @return \Illuminate\Http\Response
     */
    public function edit(Pin_Sac $pin_Sac)
    {
        return view('admin/edit-page/edit-pin', ['pin_Sac' => $pin_Sac]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePin_SacRequest  $request
     * @param  \App\Models\Pin_Sac  $pin_Sac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pin_Sac $pin_Sac)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'dungluongpin' => 'required|max:500',
                'loaipin' => 'required|max:500',
                'hotrosactoida' => 'required|max:500',
                'sackemtheomay' => 'required|max:500',
                'congnghepin' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'dungluongpin' => 'Dung lượng pin',
                'loaipin' => 'Loại pin',
                'hotrosactoida' => 'Hỗ trợ sạc tối đa',
                'sackemtheomay' => 'Sạc kèm theo máy',
                'congnghepin' => 'Công nghệ pin',
            ]
        )->validate();

        $pin_Sac->fill([
            'dung_luong_pin' => $request->input('dungluongpin'),
            'loai_pin' => $request->input('loaipin'),
            'ho_tro_sac_toi_da' => $request->input('hotrosactoida'),
            'sac_kem_theo_may' => $request->input('sackemtheomay'),
            'cong_nghe_pin' => $request->input('congnghepin'),
        ]);
        if ($pin_Sac->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật pin - sạc thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật pin - sạc không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pin_Sac  $pin_Sac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pin_Sac $pin_Sac)
    {
        if ($pin_Sac->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa pin - sạc thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa pin - sạc không thành công !');
    }
}
