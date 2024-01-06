<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class CheckCustomer extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            return $next($request);
        } else {
            if (Auth::user()->loai_tai_khoan_id < 5) {
                return redirect()->intended('/admin');
            }
            return $next($request);
        }
    }
}
