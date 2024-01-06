<?php

namespace App\Http\Controllers;

use App\Models\PhanHoiDanhGia;
use App\Models\DanhGia;
use App\Models\TaiKhoan;
use App\Models\ChiTietDonHang;
use App\Models\ThongTinTaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PhanHoiDanhGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhanHoiDanhGiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhanHoiDanhGia  $phanHoiDanhGia
     * @return \Illuminate\Http\Response
     */
    public function show(PhanHoiDanhGia $phanHoiDanhGia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhanHoiDanhGia  $phanHoiDanhGia
     * @return \Illuminate\Http\Response
     */
    public function edit(PhanHoiDanhGia $phanHoiDanhGia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhanHoiDanhGiaRequest  $request
     * @param  \App\Models\PhanHoiDanhGia  $phanHoiDanhGia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhanHoiDanhGia $phanHoiDanhGia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhanHoiDanhGia  $phanHoiDanhGia
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhanHoiDanhGia $phanHoiDanhGia)
    {
        //
    }

    public function indexPHDanhGia($danhGiaId)
    {
        $danhGia = DanhGia::where('id', '=', $danhGiaId)->first();
        $danhSachPHDanhGia = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
            ->where('phan_hoi_danh_gias.danh_gia_id', '=', $danhGiaId)
            ->select('phan_hoi_danh_gias.*', 'tai_khoans.username')
            ->get();
        return view('admin/management-page/feedback-review', ['danhSachPHDanhGia' => $danhSachPHDanhGia, 'danhGia' => $danhGia]);
    }

    public function thayDoiTrangThaiPHDanhGia($pHDanhGiaId)
    {
        $phanHoiDanhGia = PhanHoiDanhGia::where('id', '=', $pHDanhGiaId)->first();
        if ($phanHoiDanhGia->trang_thai == 1) {
            $phanHoiDanhGia->fill([
                'trang_thai' => 0,
            ]);
            if ($phanHoiDanhGia->save() == true) {
                return redirect()->back()->with('thongbao', 'Cập nhật trạng thái phản hồi đánh giá thành công !');
            }
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái phản hồi đánh giá không thành công !');
        }
        $phanHoiDanhGia->fill([
            'trang_thai' => 1,
        ]);
        if ($phanHoiDanhGia->save() == true) {
            return redirect()->back()->with('thongbao', 'Cập nhật trạng thái phản hồi đánh giá thành công !');
        }
        return redirect()->back()->with('thongbao', 'Cập nhật trạng thái phản hồi đánh giá không thành công !');
    }

    public function storePHDanhGia(Request $request)
    {
        $phanHoiDanhGia = new PhanHoiDanhGia();
        $phanHoiDanhGia->fill([
            'tai_khoan_id' => Auth::user()->id,
            'danh_gia_id' => $request->input('danhgiaid'),
            'noi_dung' => $request->input('noidung'),
            'trang_thai' => 1,
        ]);
        if ($phanHoiDanhGia->save() == true) {
            return redirect()->back()->with('thongbao', 'Thêm phản hồi đánh giá thành công !');
        }
        return redirect()->back()->with('thongbao', 'Thêm phản hồi đánh giá không thành công !');
    }

    public function storePHDanhGiaKH(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'noiDung' => 'required|max:300',
            ],
            $messages = [
                'required' => ':attribute không được bỏ trống !',
                'max' => ':attribute vượt quá số ký tự cho phép !',
            ],
            [
                'noiDung' => 'Nội dung thảo luận',
            ]
        );

        if ($validated->fails()) {
            $errors = $validated->getMessageBag();
            $msg = '';
            foreach ($errors->all() as $tp) {
                $msg .= $tp . ' ';
            }
            return response()->json(
                $msg,
                404,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
        }

        if(Auth::guest() == true){
            return response()->json(
                0,
                404,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
            // return redirect()->intended('/signin');
        }
        $phanHoiDanhGia = new PhanHoiDanhGia();
        $phanHoiDanhGia->fill([
            'tai_khoan_id' => Auth::user()->id,
            'danh_gia_id' => $request->danhGiaId,
            'noi_dung' => $request->noiDung,
            'trang_thai' => 1,
        ]);
        $danhGia = DanhGia::where('id','=',$request->danhGiaId)->first();
        if ($phanHoiDanhGia->save() == true) {
            $danhSachPhanHoi = PhanHoiDanhGia::join('tai_khoans', 'tai_khoans.id', '=', 'phan_hoi_danh_gias.tai_khoan_id')
                ->select('phan_hoi_danh_gias.*', 'tai_khoans.username', 'tai_khoans.loai_tai_khoan_id')
                ->get();
            $output = '';
            foreach($danhSachPhanHoi as $tp){
                if($tp->danh_gia_id == $request->danhGiaId){
                    $output .='<div class="comment-item '.$danhGia->username.' childC-item">
                    <div class="item-top">
                        <p class="txtname" style="text-transform:none">'. $tp->username .'</p>';
                        if ($tp->loai_tai_khoan_id < 5){
                            $output .='<span class="qtv">QTV</span>';
                        }
                    $output .='</div>
                    <div class="item-rate">
                    </div>
                    <div class="comment-content">
                        <p class="cmt-txt">'. $tp->noi_dung .'</p>
                    </div>
                </div>';
                }
            }
            return response()->json($output);
        }
        return response()->json(
            'Thêm thảo luận không thành công !',
            404,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }
}
