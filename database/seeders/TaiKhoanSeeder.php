<?php

namespace Database\Seeders;

use App\Models\TaiKhoan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaiKhoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaiKhoan::create([
            'loai_tai_khoan_id'=> 1,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'admin',
            'password'=> bcrypt('admin123'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);

        TaiKhoan::create([
            'loai_tai_khoan_id'=> 2,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'quanlycuahang1',
            'password'=> bcrypt('quanlycuahang1'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);

        TaiKhoan::create([
            'loai_tai_khoan_id'=> 3,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'quanlykho1',
            'password'=> bcrypt('quanlykho1'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);

        TaiKhoan::create([
            'loai_tai_khoan_id'=> 4,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'nhanviencuahang1',
            'password'=> bcrypt('nhanviencuahang1'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);
        TaiKhoan::create([
            'loai_tai_khoan_id'=> 4,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'nhanviencuahang2',
            'password'=> bcrypt('nhanviencuahang2'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);

        TaiKhoan::create([
            'loai_tai_khoan_id'=> 4,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'nhanvienkho1',
            'password'=> bcrypt('nhanvienkho1'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);

        TaiKhoan::create([
            'loai_tai_khoan_id'=> 4,
            'bac_tai_khoan_id'=> 1,
            'username'=> 'nhanvienkho2',
            'password'=> bcrypt('nhanvienkho2'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);

        TaiKhoan::create([
            'loai_tai_khoan_id'=> 5,
            'bac_tai_khoan_id'=> 2,
            'username'=> 'nguyenvana',
            'password'=> bcrypt('nguyenvana'),
            'diem_thuong'=> 0,
            'token'=> Str::random(60),
            'trang_thai'=> 1,
        ]);
    }
}
