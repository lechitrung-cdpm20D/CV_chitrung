<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTinTaiKhoan extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $casts = [
    //     'ngay_sinh' => 'datetime:d/m/Y', // Định dạng lại ngày
    // ];
}
