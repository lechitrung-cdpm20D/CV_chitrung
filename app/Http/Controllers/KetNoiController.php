<?php

namespace App\Http\Controllers;

use App\Models\KetNoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KetNoiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $danhSachKetNoi = KetNoi::All();
        return view('admin/management-page/connect', ['danhSachKetNoi' => $danhSachKetNoi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/add-page/add-connect');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKetNoiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'mangdidong' => 'required|max:500',
                'sim' => 'required|max:500',
                'wifi' => 'required|max:500',
                'gps' => 'required|max:500',
                'bluetooth' => 'required|max:500',
                'congketnoi' => 'required|max:500',
                'jacktainghe' => 'required|max:500',
                'ketnoikhac' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'mangdidong' => 'Mạng di động',
                'sim' => 'Sim',
                'wifi' => 'Wifi',
                'gps' => 'Gps',
                'bluetooth' => 'Bluetooth',
                'congketnoi' => 'Cổng kết nối',
                'jacktainghe' => 'Jack tai nghe',
                'ketnoikhac' => 'Kết nối khác',
            ]
        )->validate();

        $ketNoi = new KetNoi();
        $ketNoi->fill([
            'mang_di_dong' => $request->input('mangdidong'),
            'sim' => $request->input('sim'),
            'wifi' => $request->input('wifi'),
            'gps' => $request->input('gps'),
            'bluetooth' => $request->input('bluetooth'),
            'cong_ket_noi' => $request->input('congketnoi'),
            'jack_tai_nghe' => $request->input('jacktainghe'),
            'ket_noi_khac' => $request->input('ketnoikhac'),
        ]);
        if ($ketNoi->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm kết nối thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm kết nối không thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KetNoi  $ketNoi
     * @return \Illuminate\Http\Response
     */
    public function show(KetNoi $ketNoi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KetNoi  $ketNoi
     * @return \Illuminate\Http\Response
     */
    public function edit(KetNoi $ketNoi)
    {
        return view('admin/edit-page/edit-connect', ['ketNoi' => $ketNoi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKetNoiRequest  $request
     * @param  \App\Models\KetNoi  $ketNoi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KetNoi $ketNoi)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'mangdidong' => 'required|max:500',
                'sim' => 'required|max:500',
                'wifi' => 'required|max:500',
                'gps' => 'required|max:500',
                'bluetooth' => 'required|max:500',
                'congketnoi' => 'required|max:500',
                'jacktainghe' => 'required|max:500',
                'ketnoikhac' => 'required|max:500',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => 'Vượt quá số ký tự cho phép ! :attribute tối đa là 500 ký tự !',
            ],
            [
                'mangdidong' => 'Mạng di động',
                'sim' => 'Sim',
                'wifi' => 'Wifi',
                'gps' => 'Gps',
                'bluetooth' => 'Bluetooth',
                'congketnoi' => 'Cổng kết nối',
                'jacktainghe' => 'Jack tai nghe',
                'ketnoikhac' => 'Kết nối khác',
            ]
        )->validate();

        $ketNoi->fill([
            'mang_di_dong' => $request->input('mangdidong'),
            'sim' => $request->input('sim'),
            'wifi' => $request->input('wifi'),
            'gps' => $request->input('gps'),
            'bluetooth' => $request->input('bluetooth'),
            'cong_ket_noi' => $request->input('congketnoi'),
            'jack_tai_nghe' => $request->input('jacktainghe'),
            'ket_noi_khac' => $request->input('ketnoikhac'),
        ]);
        if ($ketNoi->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật kết nối thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật kết nối không thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KetNoi  $ketNoi
     * @return \Illuminate\Http\Response
     */
    public function destroy(KetNoi $ketNoi)
    {
        if ($ketNoi->delete()) {
            return redirect()->back()->with('thongbao', 'Xóa kết nối thành công !');
        }
        return redirect()->back()->with('thongbao', 'Xóa kết nối không thành công !');
    }
}
