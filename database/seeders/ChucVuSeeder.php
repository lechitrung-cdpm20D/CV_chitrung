<?php

namespace Database\Seeders;

use App\Models\ChucVu;
use Illuminate\Database\Seeder;

class ChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChucVu::create([
            'ten_chuc_vu'=> 'Quản lý cửa hàng',
            'luong_co_ban'=> 15000000,
        ]);

        ChucVu::create([
            'ten_chuc_vu'=> 'Quản lý kho',
            'luong_co_ban'=> 15000000,
        ]);

        ChucVu::create([
            'ten_chuc_vu'=> 'Nhân viên',
            'luong_co_ban'=> 10000000,
        ]);
    }
}
