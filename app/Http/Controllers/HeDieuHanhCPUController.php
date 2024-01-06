<?php

namespace App\Http\Controllers;

use App\Models\HeDieuHanh_CPU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeDieuHanhCPUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachHeDieuHanh = HeDieuHanh_CPU::All();
        return view('admin/management-page/os', ['danhSachHeDieuHanh' => $danhSachHeDieuHanh]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-os');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHeDieuHanh_CPURequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'hedieuhanh' => 'required|max:500',
                'chipxuly' => 'required|max:500',
                'tocdocpu' => 'required|max:500',
                'chipdohoa' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'hedieuhanh' => 'Hệ điều hành',
                'chipxuly' => 'Chip xử lý',
                'tocdocpu' => 'Tốc độ CPU',
                'chipdohoa' => 'Chip đồ họa',
            ]
        )->validate();

        $heDieuHanh_CPU = new HeDieuHanh_CPU();
        $heDieuHanh_CPU->fill([
            'he_dieu_hanh' => $request->input('hedieuhanh'),
            'chip_xu_ly' => $request->input('chipxuly'),
            'toc_do_cpu' => $request->input('tocdocpu'),
            'chip_do_hoa' => $request->input('chipdohoa'),
        ]);
        if ($heDieuHanh_CPU->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm hệ điều hành - CPU thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm hệ điều hành - CPU không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeDieuHanh_CPU  $heDieuHanh_CPU
     * @return \Illuminate\Http\Response
     */
    public function show(HeDieuHanh_CPU $heDieuHanh_CPU)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeDieuHanh_CPU  $heDieuHanh_CPU
     * @return \Illuminate\Http\Response
     */
    public function edit(HeDieuHanh_CPU $heDieuHanh_CPU)
    {
        return view('admin/edit-page/edit-os', ['heDieuHanh_CPU' => $heDieuHanh_CPU]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHeDieuHanh_CPURequest  $request
     * @param  \App\Models\HeDieuHanh_CPU  $heDieuHanh_CPU
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeDieuHanh_CPU $heDieuHanh_CPU)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'hedieuhanh' => 'required|max:500',
                'chipxuly' => 'required|max:500',
                'tocdocpu' => 'required|max:500',
                'chipdohoa' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'hedieuhanh' => 'Hệ điều hành',
                'chipxuly' => 'Chip xử lý',
                'tocdocpu' => 'Tốc độ CPU',
                'chipdohoa' => 'Chip đồ họa',
            ]
        )->validate();

        $heDieuHanh_CPU->fill([
            'he_dieu_hanh' => $request->input('hedieuhanh'),
            'chip_xu_ly' => $request->input('chipxuly'),
            'toc_do_cpu' => $request->input('tocdocpu'),
            'chip_do_hoa' => $request->input('chipdohoa'),
        ]);
        if ($heDieuHanh_CPU->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật hệ điều hành - CPU thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật hệ điều hành - CPU không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeDieuHanh_CPU  $heDieuHanh_CPU
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeDieuHanh_CPU $heDieuHanh_CPU)
    {
        if ($heDieuHanh_CPU->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa hệ điều hành - CPU thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa hệ điều hành - CPU không thành công !');
    }
}
