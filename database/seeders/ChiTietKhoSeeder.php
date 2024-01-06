<?php

namespace Database\Seeders;

use App\Models\ChiTietKho;
use Illuminate\Database\Seeder;

class ChiTietKhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i =1;$i<21;$i++){
            ChiTietKho::create([
                'kho_id'=> 2,
                'chi_tiet_dien_thoai_id'=> $i,
                'so_luong'=> 100,
                'ngay_nhap'=> '2022-01-01',
            ]);
        }
    }
}
