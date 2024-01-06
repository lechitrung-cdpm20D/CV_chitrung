<?php

namespace Database\Seeders;

use App\Models\CameraTruoc;
use Illuminate\Database\Seeder;

class CameraTruocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CameraTruoc::create([
            'do_phan_giai' => '32 MP',
            'tinh_nang' => 'HDR - Làm đẹp - Nhãn dán (AR Stickers) - Nhận diện khuôn mặt - Quay video Full HD - Toàn cảnh (Panorama) - Tự động lấy nét (AF) - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '12 MP',
            'tinh_nang' => 'HDR - Nhận diện khuôn mặt - Quay video 4K - Quay video Full HD - Quay video HD - Tự động lấy nét (AF) - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '40 MP',
            'tinh_nang' => 'Bộ lọc màu - Chống rung - Chụp đêm - Góc rộng (Wide) - HDR - Live Photo - Làm đẹp - Làm đẹp A.I - Nhận diện khuôn mặt - Quay chậm (Slow Motion) - Quay video 4K - Quay video Full HD - Quay video HD - Trôi nhanh thời gian (Time Lapse) - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '50 MP',
            'tinh_nang' => 'A.I Camera - Làm đẹp - Nhãn dán (AR Stickers) - Nhận diện khuôn mặt - Quay chậm (Slow Motion) - Quay video Full HD - Quay video HD - Tự động lấy nét (AF) - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '32 MP',
            'tinh_nang' => 'Bộ lọc màu - Chân dung đêm - Chụp bằng cử chỉ - Flash màn hình - HDR - Hiệu ứng Bokeh - Làm đẹp A.I - Quay chậm (Slow Motion) - Quay video Full HD - Quay video HD - Toàn cảnh (Panorama) - Trôi nhanh thời gian (Time Lapse) - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '16 MP',
            'tinh_nang' => 'Bộ lọc màu - Chụp đêm - HDR - Hiệu ứng Bokeh - Làm đẹp - Nhận diện khuôn mặt - Quay video Full HD - Quay video HD - Toàn cảnh (Panorama) - Trôi nhanh thời gian (Time Lapse) - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '8 MP',
            'tinh_nang' => 'Chụp đêm - Làm đẹp - Xóa phông',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => '5 MP',
            'tinh_nang' => 'Không có',
        ]);
        CameraTruoc::create([
            'do_phan_giai' => 'Không có',
            'tinh_nang' => 'Không có',
        ]);
    }
}
