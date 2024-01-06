<?php

namespace App\Http\Controllers;

use App\Models\PhuCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhuCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachPhuCap = PhuCap::All();
        return view('admin/management-page/allowance', ['danhSachPhuCap' => $danhSachPhuCap]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-allowance');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhuCapRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'maphucap' => 'required',
                'tienphucap' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'maphucap' => 'Mã phụ cấp',
                'tienphucap' => 'Tiền phụ cấp'
            ]
        )->validate();

        //Định dạng lại mã phụ cấp
        $maPhuCapFormat=trim( $request->input('maphucap'));
        $tontai = PhuCap::where('ma_phu_cap', 'like', $maPhuCapFormat)->first();
        if (empty($tontai)) {
            $kT = str_replace(' ', '', $maPhuCapFormat);
            $tontai = PhuCap::where('ma_phu_cap', 'like', $kT)->first();
            if (empty($tontai)) {
                $phuCap = new PhuCap;
                $phuCap->fill([
                    'ma_phu_cap' => $maPhuCapFormat,
                    'tien_phu_cap' => $request->input('tienphucap'),
                ]);
                if ($phuCap->save() == true) {
                    return redirect()->back()->with('thongbao', 'Thêm phụ cấp thành công !');
                }
                return redirect()->back()->with('thongbao', 'Thêm phụ cấp không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Thêm phụ cấp không thành công ! Mã phụ cấp đã tồn tại !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhuCap  $phuCap
     * @return \Illuminate\Http\Response
     */
    public function show(PhuCap $phuCap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhuCap  $phuCap
     * @return \Illuminate\Http\Response
     */
    public function edit(PhuCap $phuCap)
    {
        return view('admin/edit-page/edit-allowance', ['phuCap' => $phuCap]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhuCapRequest  $request
     * @param  \App\Models\PhuCap  $phuCap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhuCap $phuCap)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'maphucap' => 'required',
                'tienphucap' => 'required|numeric|min:0'
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'numeric' => ':attribute phải là kiểu số !',
                'min' => ':attribute tối thiểu là 0 !'
            ],
            [
                'maphucap' => 'Mã phụ cấp',
                'tienphucap' => 'Tiền phụ cấp'
            ]
        )->validate();

        //Định dạng lại mã phụ cấp
        $maPhuCapFormat=trim( $request->input('maphucap'));
        $tontai = PhuCap::where('ma_phu_cap', 'like', $maPhuCapFormat)->where('ma_phu_cap','!=',$phuCap->ma_phu_cap)->first();
        if (empty($tontai)) {
            $kT = str_replace(' ', '', $maPhuCapFormat);
            $tontai = PhuCap::where('ma_phu_cap', 'like', $kT)->where('ma_phu_cap','!=',$phuCap->ma_phu_cap)->first();
            if (empty($tontai)) {
                $phuCap->fill([
                    'ma_phu_cap' => $maPhuCapFormat,
                    'tien_phu_cap' => $request->input('tienphucap'),
                ]);
                if ($phuCap->save() == true) {
                    return redirect()->route('phuCap.edit', ['phuCap' => $phuCap])->with('thongbao', 'Cập nhật phụ cấp thành công !');
                }
                return redirect()->back()->with('thongbao', 'Cập nhật phụ cấp không thành công !');
            }
        }
        return redirect()->back()->with('thongbao', 'Cập nhật phụ cấp không thành công ! Mã phụ cấp đã tồn tại !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhuCap  $phuCap
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhuCap $phuCap)
    {
        if ($phuCap->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa phụ cấp thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa phụ cấp không thành công !');
    }
}
