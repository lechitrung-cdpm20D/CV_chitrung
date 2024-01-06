<?php

namespace App\Http\Controllers;

use App\Models\CameraTruoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CameraTruocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachCameraTruoc = CameraTruoc::All();
        return view('admin/management-page/frontcamera', ['danhSachCameraTruoc' => $danhSachCameraTruoc]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-frontcamera');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCameraTruocRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'dophangiai' => 'required|max:500',
                'tinhnang' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'dophangiai' => 'Độ phân giải',
                'tinhnang' => 'Tính năng',
            ]
        )->validate();

        $cameraTruoc = new CameraTruoc();
        $cameraTruoc->fill([
            'do_phan_giai' => $request->input('dophangiai'),
            'tinh_nang' => $request->input('tinhnang'),
        ]);
        if ($cameraTruoc->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm camera trước thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm camera trước không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CameraTruoc  $cameraTruoc
     * @return \Illuminate\Http\Response
     */
    public function show(CameraTruoc $cameraTruoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CameraTruoc  $cameraTruoc
     * @return \Illuminate\Http\Response
     */
    public function edit(CameraTruoc $cameraTruoc)
    {
        return view('admin/edit-page/edit-frontcamera', ['cameraTruoc' => $cameraTruoc]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCameraTruocRequest  $request
     * @param  \App\Models\CameraTruoc  $cameraTruoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CameraTruoc $cameraTruoc)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'dophangiai' => 'required|max:500',
                'tinhnang' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'dophangiai' => 'Độ phân giải',
                'tinhnang' => 'Tính năng',
            ]
        )->validate();

        $cameraTruoc->fill([
            'do_phan_giai' => $request->input('dophangiai'),
            'tinh_nang' => $request->input('tinhnang'),
        ]);
        if ($cameraTruoc->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật camera trước thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật camera trước không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CameraTruoc  $cameraTruoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(CameraTruoc $cameraTruoc)
    {
        if ($cameraTruoc->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa camera trước thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa camera trước không thành công !');
    }
}
