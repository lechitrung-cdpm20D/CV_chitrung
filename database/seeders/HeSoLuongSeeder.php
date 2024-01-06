<?php

namespace Database\Seeders;

use App\Models\HeSoLuong;
use Illuminate\Database\Seeder;

class HeSoLuongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeSoLuong::create([
            'ma_hsl'=> 'A',
            'he_so_luong'=> 1,
        ]);
        HeSoLuong::create([
            'ma_hsl'=> 'B',
            'he_so_luong'=> 1.5,
        ]);
        HeSoLuong::create([
            'ma_hsl'=> 'C',
            'he_so_luong'=> 2,
        ]);
        HeSoLuong::create([
            'ma_hsl'=> 'D',
            'he_so_luong'=> 2.5,
        ]);

    }
}
