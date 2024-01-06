<?php

namespace Database\Seeders;

use App\Models\PhuCap;
use Illuminate\Database\Seeder;

class PhuCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhuCap::create([
            'ma_phu_cap'=> 'phucap00',
            'tien_phu_cap'=> 0,
        ]);
        PhuCap::create([
            'ma_phu_cap'=> 'phucap01',
            'tien_phu_cap'=> 500000,
        ]);
        PhuCap::create([
            'ma_phu_cap'=> 'phucap02',
            'tien_phu_cap'=> 1000000,
        ]);
        PhuCap::create([
            'ma_phu_cap'=> 'phucap03',
            'tien_phu_cap'=> 1500000,
        ]);
    }
}
