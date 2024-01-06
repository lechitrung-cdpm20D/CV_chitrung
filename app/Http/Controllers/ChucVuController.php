<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChucVuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachChucVu = ChucVu::All();
        return view('admin/management-page/position', ['danhSachChucVu' => $danhSachChucVu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-position');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChucVuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenchucvu' => 'required|max:30',
                'luongcoban' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'tenchucvu' => 'Tên chức vụ',
                'luongcoban' => 'Lương cơ bản'
            ]
        )->validate();

        //Định dạng lại tên chức vụ
        $tenChucVuFormat=trim( $request->input('tenchucvu'));
        $tontai = ChucVu::where('ten_chuc_vu', 'like', $tenChucVuFormat)->first();
        if (empty($tontai)) {
            $kTTenChucVu = str_replace(' ', '', $tenChucVuFormat);
            $tontai = ChucVu::where('ten_chuc_vu', 'like', $kTTenChucVu)->first();
            if (empty($tontai)) {
                $chucVu = new ChucVu;
                $chucVu->fill([
                    'ten_chuc_vu' => $tenChucVuFormat,
                    'luong_co_ban' => $request->input('luongcoban'),
                ]);
                if ($chucVu->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm chức vụ thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm chức vụ không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm chức vụ không thành công ! Chức vụ đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChucVu  $chucVu
     * @return \Illuminate\Http\Response
     */
    public function show(ChucVu $chucVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChucVu  $chucVu
     * @return \Illuminate\Http\Response
     */
    public function edit(ChucVu $chucVu)
    {
        return view('admin/edit-page/edit-position', ['chucVu' => $chucVu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChucVuRequest  $request
     * @param  \App\Models\ChucVu  $chucVu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChucVu $chucVu)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenchucvu' => 'required|max:30',
                'luongcoban' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 30 ký tự !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'tenchucvu' => 'Tên chức vụ',
                'luongcoban' => 'Lương cơ bản'
            ]
        )->validate();

        //Định dạng lại tên chức vụ
        $tenChucVuFormat=trim( $request->input('tenchucvu'));
        $tontai = ChucVu::where('ten_chuc_vu', 'like', $tenChucVuFormat)->where('id','!=',$chucVu->id)->first();
        if (empty($tontai)) {
            $kTTenChucVu = str_replace(' ', '', $tenChucVuFormat);
            $tontai = ChucVu::where('ten_chuc_vu', 'like', $kTTenChucVu)->where('id','!=',$chucVu->id)->first();
            if (empty($tontai)) {
                $chucVu->fill([
                    'ten_chuc_vu' => $tenChucVuFormat,
                    'luong_co_ban' => $request->input('luongcoban'),
                ]);
                if ($chucVu->save() == true) {
                    return redirect()->back()->with('thongbao', 'Cập nhật chức vụ thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật chức vụ không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm chức vụ không thành công ! Chức vụ đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChucVu  $chucVu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChucVu $chucVu)
    {
        if ($chucVu->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa chức vụ thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa chức vụ không thành công !');
    }
}
