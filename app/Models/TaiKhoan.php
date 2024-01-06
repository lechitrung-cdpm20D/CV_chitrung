<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaiKhoan extends Authenticatable
{
    use HasFactory,Notifiable,SoftDeletes;
    protected $guarded = [];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey ='id';
    protected $fillable = [
        "id",'username', 'password','loai_tai_khoan_id','diem_thuong','token','trang_thai','bac_tai_khoan_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'token'
    ];

}
