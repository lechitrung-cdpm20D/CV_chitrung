<?php

namespace App\Http\Controllers;

use App\Models\BacTaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BacTaiKhoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachBac = BacTaiKhoan::where('id', '!=', 1)->get();
        return view('admin/management-page/membershiplevel', ['danhSachBac' => $danhSachBac]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-membershiplevel');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBacTaiKhoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenbac' => 'required|max:100',
                'hanmuc' => 'required|min:0|numeric',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute vượt quá giá trị cho phép !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
            ],
            [
                'tenbac' => 'Tên bậc thành viên',
                'hanmuc' => 'Hạn mức',
            ]
        )->validate();

        //Định dạng lại tên bậc
        $tenBacFormat = trim($request->input('tenbac'));
        $tontai = BacTaiKhoan::where('ten_bac_tai_khoan', 'like', $tenBacFormat)->first();
        if (empty($tontai)) {
            $kTTenBac = str_replace(' ', '', $tenBacFormat);
            $tontai = BacTaiKhoan::where('ten_bac_tai_khoan', 'like', $kTTenBac)->first();
            if (empty($tontai)) {
                $bacTaiKhoan = new BacTaiKhoan;
                $bacTaiKhoan->fill([
                    'ten_bac_tai_khoan' => $tenBacFormat,
                    'han_muc' => $request->input('hanmuc'),
                ]);
                if($bacTaiKhoan->save() == true){
                    return redirect()->back()->with('thongbao', 'Thêm bậc thành viên thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm bậc thành viên không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm bậc thành viên không thành công ! Tên bậc thành viên đã tồn tại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BacTaiKhoan  $bacTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function show(BacTaiKhoan $bacTaiKhoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BacTaiKhoan  $bacTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function edit(BacTaiKhoan $bacTaiKhoan)
    {
        return view('admin/edit-page/edit-membershiplevel', ['bacTaiKhoan' => $bacTaiKhoan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBacTaiKhoanRequest  $request
     * @param  \App\Models\BacTaiKhoan  $bacTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BacTaiKhoan $bacTaiKhoan)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'tenbac' => 'required|max:100',
                'hanmuc' => 'required|min:0|numeric',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute vượt quá giá trị cho phép !',
                'min' => ':attribute tối thiểu là 0 !',
                'numeric' => ':attribute phải là kiểu số!',
            ],
            [
                'tenbac' => 'Tên bậc thành viên',
                'hanmuc' => 'Hạn mức',
            ]
        )->validate();

        //Định dạng lại tên bậc
        $tenBacFormat = trim($request->input('tenbac'));
        $tontai = BacTaiKhoan::where('ten_bac_tai_khoan', 'like', $tenBacFormat)->where('id','!=',$bacTaiKhoan->id)->first();
        if (empty($tontai)) {
            $kTTenBac = str_replace(' ', '', $tenBacFormat);
            $tontai = BacTaiKhoan::where('ten_bac_tai_khoan', 'like', $kTTenBac)->where('id','!=',$bacTaiKhoan->id)->first();
            if (empty($tontai)) {
                $bacTaiKhoan->fill([
                    'ten_bac_tai_khoan' => $tenBacFormat,
                    'han_muc' => $request->input('hanmuc'),
                ]);
                if($bacTaiKhoan->save() == true){
                    return redirect()->back()->with('thongbao', 'Cập nhật bậc thành viên thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật bậc thành viên không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật bậc thành viên không thành công ! Tên bậc thành viên đã tồn tại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BacTaiKhoan  $bacTaiKhoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(BacTaiKhoan $bacTaiKhoan)
    {
        if ($bacTaiKhoan->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa bậc thành viên thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa bậc thành viên không thành công !');
    }
}
