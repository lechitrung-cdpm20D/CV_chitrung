<?php

namespace App\Http\Controllers;

use App\Models\Thuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThuongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachThuong = Thuong::All();
        return view('admin/management-page/bonus', ['danhSachThuong' => $danhSachThuong]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-bonus');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreThuongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'mathuong' => 'required',
                'tienthuong' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'mathuong' => 'Mã thưởng',
                'tienthuong' => 'Tiền thưởng'
            ]
        )->validate();

        //Định dạng lại mã thưởng
        $maThuongFormat=trim( $request->input('mathuong'));
        $tontai = Thuong::where('ma_thuong', 'like', $maThuongFormat)->first();
        if (empty($tontai)) {
            $kT = str_replace(' ', '', $maThuongFormat);
            $tontai = Thuong::where('ma_thuong', 'like', $kT)->first();
            if (empty($tontai)) {
                $thuong = new Thuong;
                $thuong->fill([
                    'ma_thuong' => $maThuongFormat,
                    'tien_thuong' => $request->input('tienthuong'),
                ]);
                if ($thuong->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm thưởng thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm thưởng không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm thưởng không thành công ! Mã thưởng đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thuong  $thuong
     * @return \Illuminate\Http\Response
     */
    public function show(Thuong $thuong)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thuong  $thuong
     * @return \Illuminate\Http\Response
     */
    public function edit(Thuong $thuong)
    {
        return view('admin/edit-page/edit-bonus', ['thuong' => $thuong]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateThuongRequest  $request
     * @param  \App\Models\Thuong  $thuong
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thuong $thuong)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'mathuong' => 'required',
                'tienthuong' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'mathuong' => 'Mã thưởng',
                'tienthuong' => 'Tiền thưởng'
            ]
        )->validate();

        //Định dạng lại mã thưởng
        $maThuongFormat=trim( $request->input('mathuong'));
        $tontai = Thuong::where('ma_thuong', 'like', $maThuongFormat)->where('ma_thuong','!=',$thuong->ma_thuong)->first();
        if (empty($tontai)) {
            $kT = str_replace(' ', '', $maThuongFormat);
            $tontai = Thuong::where('ma_thuong', 'like', $kT)->where('ma_thuong','!=',$thuong->ma_thuong)->first();
            if (empty($tontai)) {
                $thuong->fill([
                    'ma_thuong' => $maThuongFormat,
                    'tien_thuong' => $request->input('tienthuong'),
                ]);
                if ($thuong->save() == true) {
                    return redirect()->route('thuong.edit', ['thuong' => $thuong])->with('thongbao', 'Cập nhật thưởng thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật thưởng không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật thưởng không thành công ! Mã thưởng đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thuong  $thuong
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thuong $thuong)
    {
        if ($thuong->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa thưởng thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa thưởng không thành công !');
    }
}
