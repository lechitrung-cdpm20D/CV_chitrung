<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\TaiKhoan;
use App\Models\ThongTinTaiKhoan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class SocialController extends Controller
{
    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $taiKhoan = TaiKhoan::where('username', '=', $user->email)->first();
        if (empty($taiKhoan)) {
            //Tạo tài khoản
            $taiKhoan = new TaiKhoan();
            $taiKhoan->username = $user->email;
            $taiKhoan->loai_tai_khoan_id = 8;
            $taiKhoan->bac_tai_khoan_id = 2;
            $taiKhoan->diem_thuong = 0;
            $taiKhoan->password = bcrypt($user->id);
            $taiKhoan->token = Str::random(60);
            $taiKhoan->trang_thai = 1;
            $taiKhoan->save();
            //Tạo thông tin tài khoản
            $thongTinTaiKhoan = new ThongTinTaiKhoan();
            $thongTinTaiKhoan->tai_khoan_id = $taiKhoan->id;
            $thongTinTaiKhoan->ho_ten = $user->name;
            $thongTinTaiKhoan->dia_chi = null;
            $thongTinTaiKhoan->so_dien_thoai = null;
            $thongTinTaiKhoan->email = $user->email;
            $thongTinTaiKhoan->ngay_sinh = Carbon::now('Asia/Ho_Chi_Minh');
            $thongTinTaiKhoan->gioi_tinh = 1;
            $thongTinTaiKhoan->save();

            Auth::attempt(['username' => $taiKhoan->username, 'password' => $user->id, 'trang_thai' => 1]);
            return redirect()->route('homeuser');
        }
        if (Auth::attempt(['username' => $taiKhoan->username, 'password' => $user->id, 'trang_thai' => 1])) {
            return redirect()->route('homeuser');
        }
        return redirect()->route('signin')->with('thongbao', 'Tài khoản đã bị khóa !');
    }

    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $taiKhoan = TaiKhoan::where('username', '=', $user->email)->first();
        if (empty($taiKhoan)) {
            //Tạo tài khoản
            $taiKhoan = new TaiKhoan();
            $taiKhoan->username = $user->email;
            $taiKhoan->loai_tai_khoan_id = 6;
            $taiKhoan->bac_tai_khoan_id = 2;
            $taiKhoan->diem_thuong = 0;
            $taiKhoan->password = bcrypt($user->id);
            $taiKhoan->token = Str::random(60);
            $taiKhoan->trang_thai = 1;
            $taiKhoan->save();
            //Tạo thông tin tài khoản
            $thongTinTaiKhoan = new ThongTinTaiKhoan();
            $thongTinTaiKhoan->tai_khoan_id = $taiKhoan->id;
            $thongTinTaiKhoan->ho_ten = $user->name;
            $thongTinTaiKhoan->dia_chi = null;
            $thongTinTaiKhoan->so_dien_thoai = null;
            $thongTinTaiKhoan->email = $user->email;
            $thongTinTaiKhoan->ngay_sinh = Carbon::now('Asia/Ho_Chi_Minh');
            $thongTinTaiKhoan->gioi_tinh = 1;
            $thongTinTaiKhoan->save();

            Auth::attempt(['username' => $taiKhoan->username, 'password' => $user->id, 'trang_thai' => 1]);
            return redirect()->route('homeuser');
        }

        if (Auth::attempt(['username' => $taiKhoan->username, 'password' => $user->id, 'trang_thai' => 1])) {
            return redirect()->route('homeuser');
        }
        return redirect()->route('signin')->with('thongbao', 'Tài khoản đã bị khóa !');
    }

    // Zalo login
    public function redirectToZalo()
    {
        $config = array(
            'app_id' => '3062567892311767416',
            'app_secret' => 'L8sSTbP718SEI1uQ5AkY',
            'callback_url' => 'http://localhost:8000/login/zalo/callback'
        );
        $zalo = new Zalo($config);
        $helper = $zalo->getRedirectLoginHelper();
        $callbackUrl = "http://localhost:8000/login/zalo/callback";
        $loginUrl = $helper->getLoginUrl($callbackUrl);
        return redirect()->intended($loginUrl);
    }

    // Zalo callback
    public function handleZaloCallback()
    {
        $config = array(
            'app_id' => '3062567892311767416',
            'app_secret' => 'L8sSTbP718SEI1uQ5AkY',
            'callback_url' => 'http://localhost:8000/login/zalo/callback'
        );
        $zalo = new Zalo($config);
        $helper = $zalo->getRedirectLoginHelper();
        $callBackUrl = "http://localhost:8000/login/zalo/callback";
        $oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
        $accessToken = $helper->getAccessToken($callBackUrl); // get access token
        if ($accessToken != null) {
            $expires = $accessToken->getExpiresAt();
            $params = ['fields' => 'id,name,birthday,gender,picture']; // result// get expires time
            $response = $zalo->get(ZaloEndpoint::API_GRAPH_ME, $accessToken, $params);
            $result = $response->getDecodedBody();

            $taiKhoan = TaiKhoan::where('username', '=', $result['id'])->first();
            if (empty($taiKhoan)) {
                //Tạo tài khoản
                $taiKhoan = new TaiKhoan();
                $taiKhoan->username = $result['id'];
                $taiKhoan->loai_tai_khoan_id = 7;
                $taiKhoan->bac_tai_khoan_id = 2;
                $taiKhoan->diem_thuong = 0;
                $taiKhoan->password = bcrypt($result['id']);
                $taiKhoan->token = Str::random(60);
                $taiKhoan->trang_thai = 1;
                $taiKhoan->save();
                //Tạo thông tin tài khoản
                $thongTinTaiKhoan = new ThongTinTaiKhoan();
                $thongTinTaiKhoan->tai_khoan_id = $taiKhoan->id;
                $thongTinTaiKhoan->ho_ten = $result['name'];
                $thongTinTaiKhoan->dia_chi = null;
                $thongTinTaiKhoan->so_dien_thoai = null;
                $thongTinTaiKhoan->email = null;
                $thongTinTaiKhoan->ngay_sinh = Carbon::now('Asia/Ho_Chi_Minh');
                $thongTinTaiKhoan->gioi_tinh = 1;
                $thongTinTaiKhoan->save();

                Auth::attempt(['username' => $result['id'], 'password' => $result['id'], 'trang_thai' => 1]);
                return redirect()->route('homeuser');
            }

            if (Auth::attempt(['username' => $taiKhoan->username, 'password' => $result['id'], 'trang_thai' => 1])) {
                return redirect()->route('homeuser');
            }
            return redirect()->route('signin')->with('thongbao', 'Tài khoản đã bị khóa !');
        }
    }
}
