<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'ma_don_hang';
    public $incrementing = false;
    protected $keyType = 'string';
}
