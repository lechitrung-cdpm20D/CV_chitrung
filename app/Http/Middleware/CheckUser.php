<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class CheckUser extends Middleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->loai_tai_khoan_id <5){
                return redirect()->intended('/admin');
            }
            return redirect()->intended('/');
        }
        return $next($request);
    }
}
