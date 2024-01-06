<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class CheckStaff extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->loai_tai_khoan_id > 4) {
            return redirect()->intended('/');
        }
        return $next($request);
    }
}
