<?php

namespace Database\Seeders;

use App\Models\LoaiTaiKhoan;
use Illuminate\Database\Seeder;

class LoaiTaiKhoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Admin',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Quản lý cửa hàng',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Quản lý kho',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Nhân viên',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Người dùng T&TMobile',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Người dùng Facebook',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Người dùng Zalo',
        ]);
        LoaiTaiKhoan::create([
            'ten_loai_tai_khoan'=> 'Người dùng Google',
        ]);

    }
}
