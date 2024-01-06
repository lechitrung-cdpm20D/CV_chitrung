<?php

namespace Database\Seeders;

use App\Models\CuaHang;
use Illuminate\Database\Seeder;

class CuaHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CuaHang::create([
            'ten_cua_hang'=> 'Không có',
            'dia_chi'=> 'Không có',
            'google_map'=>null,
        ]);
        CuaHang::create([
            'ten_cua_hang'=> 'Cửa hàng 224/2A Lũy Bán Bích',
            'dia_chi'=> '224/2A Lũy Bán Bích, Hòa Thanh, Tân Phú, Hồ Chí Minh',
            'google_map'=>'https://www.google.com/maps/place/224%2F2A+Lũy+Bán+Bích,+Hoà+Thanh,+Tân+Phú,+Thành+phố+Hồ+Chí+Minh,+Việt+Nam/@10.7877934,106.6342917,17z/data=!3m1!4b1!4m5!3m4!1s0x31752eac186db1a3:0x6bad77b88262ae95!8m2!3d10.7877934!4d106.6364804?hl=vi-VN',
        ]);
        CuaHang::create([
            'ten_cua_hang'=> 'Cửa hàng 2 Tân Kỳ Tân Quý',
            'dia_chi'=> '2 Tân Kỳ Tân Quý, Bình Hưng Hòa A, Bình Tân, Hồ Chí Minh',
            'google_map'=>'https://www.google.com/maps/place/2+Tân+Kỳ+Tân+Quý,+Bình+Hưng+Hoà+A,+Bình+Tân,+Thành+phố+Hồ+Chí+Minh,+Việt+Nam/@10.7924861,106.6054022,17z/data=!3m1!4b1!4m5!3m4!1s0x31752c0aee6278bd:0xddd5098866a1f499!8m2!3d10.7924861!4d106.6075909?hl=vi-VN',
        ]);
    }
}
