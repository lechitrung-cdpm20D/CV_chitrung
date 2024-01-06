<?php

namespace App\Http\Controllers;

use App\Models\BoNho_LuuTru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoNhoLuuTruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachBoNho = BoNho_LuuTru::All();
        return view('admin/management-page/memory', ['danhSachBoNho' => $danhSachBoNho]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-memory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBoNho_LuuTruRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'ram' => 'required|max:500',
                'bonhotrong' => 'required|max:500',
                'bonhoconlai' => 'required|max:500',
                'thenho' => 'required|max:500',
                'danhba' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'ram' => 'Ram',
                'bonhotrong' => 'Bộ nhớ trong',
                'bonhoconlai' => 'Bộ nhớ còn lại',
                'thenho' => 'Thẻ nhớ',
                'danhba' => 'Danh bạ',
            ]
        )->validate();

        $boNho_LuuTru = new BoNho_LuuTru();
        $boNho_LuuTru->fill([
            'ram' => $request->input('ram'),
            'bo_nho_trong' => $request->input('bonhotrong'),
            'bo_nho_con_lai' => $request->input('bonhoconlai'),
            'the_nho' => $request->input('thenho'),
            'danh_ba' => $request->input('danhba'),
        ]);
        if ($boNho_LuuTru->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm bộ nhớ lưu trữ thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm bộ nhớ lưu trữ không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BoNho_LuuTru  $boNho_LuuTru
     * @return \Illuminate\Http\Response
     */
    public function show(BoNho_LuuTru $boNho_LuuTru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BoNho_LuuTru  $boNho_LuuTru
     * @return \Illuminate\Http\Response
     */
    public function edit(BoNho_LuuTru $boNho_LuuTru)
    {
        return view('admin/edit-page/edit-memory', ['boNho_LuuTru' => $boNho_LuuTru]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBoNho_LuuTruRequest  $request
     * @param  \App\Models\BoNho_LuuTru  $boNho_LuuTru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoNho_LuuTru $boNho_LuuTru)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'ram' => 'required|max:500',
                'bonhotrong' => 'required|max:500',
                'bonhoconlai' => 'required|max:500',
                'thenho' => 'required|max:500',
                'danhba' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'ram' => 'Ram',
                'bonhotrong' => 'Bộ nhớ trong',
                'bonhoconlai' => 'Bộ nhớ còn lại',
                'thenho' => 'Thẻ nhớ',
                'danhba' => 'Danh bạ',
            ]
        )->validate();

        $boNho_LuuTru->fill([
            'ram' => $request->input('ram'),
            'bo_nho_trong' => $request->input('bonhotrong'),
            'bo_nho_con_lai' => $request->input('bonhoconlai'),
            'the_nho' => $request->input('thenho'),
            'danh_ba' => $request->input('danhba'),
        ]);
        if ($boNho_LuuTru->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật bộ nhớ lưu trữ thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật bộ nhớ lưu trữ không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BoNho_LuuTru  $boNho_LuuTru
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoNho_LuuTru $boNho_LuuTru)
    {
        if ($boNho_LuuTru->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa bộ nhớ lưu trữ thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa bộ nhớ lưu trữ không thành công !');
    }
}
