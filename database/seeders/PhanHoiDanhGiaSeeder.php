<?php

namespace Database\Seeders;

use App\Models\PhanHoiDanhGia;
use Illuminate\Database\Seeder;

class PhanHoiDanhGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhanHoiDanhGia::create([
            'danh_gia_id'=> 1,
            'tai_khoan_id'=> 1,
            'noi_dung'=> 'Cảm ơn quý khách đã đánh giá !',
            'trang_thai'=> 1,
        ]);
    }
}
