<?php

namespace Database\Seeders;

use App\Models\PhieuGiamGia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PhieuGiamGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<5;$i++){
            PhieuGiamGia::create([
                'code'=> Str::random(8),
                'phan_tram_giam'=> 0.1,
                'ngay_bat_dau'=> '2022-01-01',
                'ngay_het_han'=> '2022-12-01',
                'trang_thai'=> 1,
            ]);
        }
    }
}
