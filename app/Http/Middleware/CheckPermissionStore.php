<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class CheckPermissionStore extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->loai_tai_khoan_id == 1 || Auth::user()->loai_tai_khoan_id == 2) {
            return $next($request);
        }
        return redirect()->intended('/admin');
    }
}
