<?php

namespace Database\Seeders;

use App\Models\ThuongHieu;
use Illuminate\Database\Seeder;

class ThuongHieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'IPHONE',
            'hinh_anh'=>'IPHONE/logo-iphone.png'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'ITEL',
            'hinh_anh'=>'ITEL/logo-itel.jpg'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'MASSTEL',
            'hinh_anh'=>'MASSTEL/logo-masstel.png'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'NOKIA',
            'hinh_anh'=>'NOKIA/logo-nokia.jpg'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'OPPO',
            'hinh_anh'=>'OPPO/logo-oppo.jpg'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'REALME',
            'hinh_anh'=>'REALME/logo-realme.png'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'SAMSUNG',
            'hinh_anh'=>'SAMSUNG/logo-samsung.png'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'VIVO',
            'hinh_anh'=>'VIVO/logo-vivo.jpg'
        ]);
        ThuongHieu::create([
            'ten_thuong_hieu'=> 'XIAOMI',
            'hinh_anh'=>'XIAOMI/logo-xiaomi.png'
        ]);
    }
}
