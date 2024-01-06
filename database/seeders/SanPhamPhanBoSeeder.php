<?php

namespace Database\Seeders;

use App\Models\SanPhamPhanBo;
use Illuminate\Database\Seeder;

class SanPhamPhanBoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i =1;$i<21;$i++){
            SanPhamPhanBo::create([
                'cua_hang_id'=> 2,
                'chi_tiet_dien_thoai_id'=> $i,
                'so_luong'=> 100,
            ]);
        }
        for($i =1;$i<21;$i++){
            SanPhamPhanBo::create([
                'cua_hang_id'=> 3,
                'chi_tiet_dien_thoai_id'=> $i,
                'so_luong'=> 0,
            ]);
        }
    }
}
