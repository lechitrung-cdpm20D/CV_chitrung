<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoNho_LuuTru extends Model
{
    use HasFactory;
    protected $table = 'bo_nho_luu_trus';
    protected $guarded = [];
}
