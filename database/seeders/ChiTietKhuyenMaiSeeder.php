<?php

namespace Database\Seeders;

use App\Models\ChiTietKhuyenMai;
use Illuminate\Database\Seeder;

class ChiTietKhuyenMaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChiTietKhuyenMai::create([
            'khuyen_mai_id'=> 1,
            'dien_thoai_id'=> 1,
            'phan_tram_giam'=> 0.15,
        ]);
        ChiTietKhuyenMai::create([
            'khuyen_mai_id'=> 1,
            'dien_thoai_id'=> 2,
            'phan_tram_giam'=> 0.1,
        ]);
        ChiTietKhuyenMai::create([
            'khuyen_mai_id'=> 1,
            'dien_thoai_id'=> 3,
            'phan_tram_giam'=> 0.1,
        ]);
        ChiTietKhuyenMai::create([
            'khuyen_mai_id'=> 1,
            'dien_thoai_id'=> 4,
            'phan_tram_giam'=> 0.1,
        ]);
        ChiTietKhuyenMai::create([
            'khuyen_mai_id'=> 1,
            'dien_thoai_id'=> 5,
            'phan_tram_giam'=> 0.05,
        ]);
        ChiTietKhuyenMai::create([
            'khuyen_mai_id'=> 1,
            'dien_thoai_id'=> 6,
            'phan_tram_giam'=> 0.05,
        ]);
    }
}
