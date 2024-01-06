<?php

namespace Database\Seeders;

use App\Models\DanhGia;
use Illuminate\Database\Seeder;

class DanhGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DanhGia::create([
            'tai_khoan_id'=> 8,
            'dien_thoai_id'=> 1,
            'noi_dung'=> 'Tốt',
            'so_sao'=> 5,
            'trang_thai'=> 1,
        ]);
    }
}
