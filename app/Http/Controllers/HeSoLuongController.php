<?php

namespace App\Http\Controllers;

use App\Models\HeSoLuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeSoLuongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachHeSoLuong = HeSoLuong::All();
        return view('admin/management-page/coefficientssalary', ['danhSachHeSoLuong' => $danhSachHeSoLuong]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-coefficientssalary');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHeSoLuongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'mahsl' => 'required',
                'hesoluong' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'mahsl' => 'Mã hệ số lương',
                'hesoluong' => 'Hệ số lương'
            ]
        )->validate();

        //Định dạng lại mã hệ số
        $maHeSoFormat=trim( $request->input('mahsl'));
        $tontai = HeSoLuong::where('ma_hsl', 'like', $maHeSoFormat)->first();
        if (empty($tontai)) {
            $kT = str_replace(' ', '', $maHeSoFormat);
            $tontai = HeSoLuong::where('ma_hsl', 'like', $kT)->first();
            if (empty($tontai)) {
                $heSoLuong = new HeSoLuong;
                $heSoLuong->fill([
                    'ma_hsl' => $maHeSoFormat,
                    'he_so_luong' => $request->input('hesoluong'),
                ]);
                if ($heSoLuong->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm hệ số lương thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm hệ số lương không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm hệ số lương không thành công ! Mã hệ số lương đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeSoLuong  $heSoLuong
     * @return \Illuminate\Http\Response
     */
    public function show(HeSoLuong $heSoLuong)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeSoLuong  $heSoLuong
     * @return \Illuminate\Http\Response
     */
    public function edit(HeSoLuong $heSoLuong)
    {
        return view('admin/edit-page/edit-coefficientssalary', ['heSoLuong' => $heSoLuong]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHeSoLuongRequest  $request
     * @param  \App\Models\HeSoLuong  $heSoLuong
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeSoLuong $heSoLuong)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'mahsl' => 'required',
                'hesoluong' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'mahsl' => 'Mã hệ số lương',
                'hesoluong' => 'Hệ số lương'
            ]
        )->validate();

        //Định dạng lại mã hệ số
        $maHeSoFormat=trim( $request->input('mahsl'));
        $tontai = HeSoLuong::where('ma_hsl', 'like', $maHeSoFormat)->where('ma_hsl','!=',$heSoLuong->ma_hsl)->first();
        if (empty($tontai)) {
            $kT = str_replace(' ', '', $maHeSoFormat);
            $tontai = HeSoLuong::where('ma_hsl', 'like', $kT)->where('ma_hsl','!=',$heSoLuong->ma_hsl)->first();
            if (empty($tontai)) {
                $heSoLuong->fill([
                    'ma_hsl' => $maHeSoFormat,
                    'he_so_luong' => $request->input('hesoluong'),
                ]);
                if ($heSoLuong->save() == true) {
                    return redirect()->route('heSoLuong.edit', ['heSoLuong' => $heSoLuong])->with('thongbao', 'Cập nhật hệ số lương thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật hệ số lương không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật hệ số lương không thành công ! Mã hệ số lương đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeSoLuong  $heSoLuong
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeSoLuong $heSoLuong)
    {
        if ($heSoLuong->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa hệ số lương thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa hệ số lương không thành công !');
    }
}
