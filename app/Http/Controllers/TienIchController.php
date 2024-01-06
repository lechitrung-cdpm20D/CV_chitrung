<?php

namespace App\Http\Controllers;

use App\Models\TienIch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TienIchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachTienIch = TienIch::All();
        return view('admin/management-page/utilities', ['danhSachTienIch' => $danhSachTienIch]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-utilities');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTienIchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'baomatnangcao' => 'required|max:500',
                'tinhnangdacbiet' => 'required|max:500',
                // 'khangnuocbui' => 'required|in:0,1',
                'khangnuocbui' => 'required|max:500',
                'ghiam' => 'required|max:500',
                'xemphim' => 'required|max:500',
                'nghenhac' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
                // 'in' => ':attribute không đúng kiểu dữ liệu cho phép !'
            ],
            [
                'baomatnangcao' => 'Bảo mật nâng cao',
                'tinhnangdacbiet' => 'Tính năng đặc biệt',
                'khangnuocbui' => 'Kháng nước bụi',
                'ghiam' => 'Ghi âm',
                'xemphim' => 'Xem phim',
                'nghenhac' => 'Nghe nhạc',
            ]
        )->validate();

        $tienIch = new TienIch();
        $tienIch->fill([
            'bao_mat_nang_cao' => $request->input('baomatnangcao'),
            'tinh_nang_dac_biet' => $request->input('tinhnangdacbiet'),
            'khang_nuoc_bui' => $request->input('khangnuocbui'),
            'ghi_am' => $request->input('ghiam'),
            'xem_phim' => $request->input('xemphim'),
            'nghe_nhac' => $request->input('nghenhac'),
        ]);
        if ($tienIch->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm tiện ích thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm tiện ích không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TienIch  $tienIch
     * @return \Illuminate\Http\Response
     */
    public function show(TienIch $tienIch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TienIch  $tienIch
     * @return \Illuminate\Http\Response
     */
    public function edit(TienIch $tienIch)
    {
        return view('admin/edit-page/edit-utilities', ['tienIch' => $tienIch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTienIchRequest  $request
     * @param  \App\Models\TienIch  $tienIch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TienIch $tienIch)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'baomatnangcao' => 'required|max:500',
                'tinhnangdacbiet' => 'required|max:500',
                // 'khangnuocbui' => 'required|in:0,1',
                'khangnuocbui' => 'required|max:500',
                'ghiam' => 'required|max:500',
                'xemphim' => 'required|max:500',
                'nghenhac' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
                // 'in' => ':attribute không đúng kiểu dữ liệu cho phép !'
            ],
            [
                'baomatnangcao' => 'Bảo mật nâng cao',
                'tinhnangdacbiet' => 'Tính năng đặc biệt',
                'khangnuocbui' => 'Kháng nước bụi',
                'ghiam' => 'Ghi âm',
                'xemphim' => 'Xem phim',
                'nghenhac' => 'Nghe nhạc',
            ]
        )->validate();

        $tienIch->fill([
            'bao_mat_nang_cao' => $request->input('baomatnangcao'),
            'tinh_nang_dac_biet' => $request->input('tinhnangdacbiet'),
            'khang_nuoc_bui' => $request->input('khangnuocbui'),
            'ghi_am' => $request->input('ghiam'),
            'xem_phim' => $request->input('xemphim'),
            'nghe_nhac' => $request->input('nghenhac'),
        ]);
        if ($tienIch->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật tiện ích thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật tiện ích không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TienIch  $tienIch
     * @return \Illuminate\Http\Response
     */
    public function destroy(TienIch $tienIch)
    {
        if ($tienIch->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa tiện ích thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa tiện ích không thành công !');
    }
}
