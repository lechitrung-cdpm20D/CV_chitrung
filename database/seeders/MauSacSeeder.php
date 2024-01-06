<?php

namespace Database\Seeders;

use App\Models\MauSac;
use Illuminate\Database\Seeder;

class MauSacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MauSac::create([
            'ten_mau_sac'=> 'Bạc',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Đen',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Xanh lá',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Xanh dương',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Tím',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Xanh',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Đỏ',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Xanh hồng',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Vàng',
        ]);
        MauSac::create([
            'ten_mau_sac'=> 'Xám',
        ]);
    }
}
