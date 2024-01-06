<?php

namespace Database\Seeders;

use App\Models\DienThoai;
use Illuminate\Database\Seeder;

class DienThoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DienThoai::create([
            'thuong_hieu_id'=> 5,
            'ten_san_pham'=> 'OPPO Reno6 Z 5G',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Cây lấy sim, Ốp lưng, Tai nghe dây, Cáp Type C, Củ sạc nhanh rời đầu Type A, Sách hướng dẫn',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 1,
            'ten_san_pham'=> 'iPhone 13 Pro Max',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cây lấy sim, Cáp Lightning - Type C',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 7,
            'ten_san_pham'=> 'Samsung Galaxy S22 Ultra 5G',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Bút cảm ứng, Cây lấy sim, Cáp Type C',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 8,
            'ten_san_pham'=> 'Vivo V23e',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Jack chuyển tai nghe 3.5mm, Cây lấy sim, Ốp lưng, Cáp Type C, Củ sạc nhanh rời đầu Type A, Tai nghe dây',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 9,
            'ten_san_pham'=> 'Xiaomi 12',
            'mo_ta'=> 'Bộ sản phẩm gồm: Cáp Type C, Cây lấy sim, Củ sạc nhanh rời đầu Type A, Hộp, Sách hướng dẫn, Ốp lưng',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 6,
            'ten_san_pham'=> 'Realme 9 Pro 5G',
            'mo_ta'=> 'Bộ sản phẩm gồm: Cáp Type C, Củ sạc nhanh rời đầu Type A, Cây lấy sim, Hộp, Sách hướng dẫn, Ốp lưng',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 4,
            'ten_san_pham'=> 'Nokia G21',
            'mo_ta'=> 'Bộ sản phẩm gồm: Cáp Type C, Củ sạc nhanh rời đầu Type A, Cây lấy sim, Hộp, Sách hướng dẫn, Ốp lưng',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 2,
            'ten_san_pham'=> 'Itel L6502',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sạc, Sách hướng dẫn, Ốp lưng, Cáp microUSB, Tai nghe dây',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 3,
            'ten_san_pham'=> 'Masstel FAMI 60 4G',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Sạc liền đầu Type C, Pin',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 9,
            'ten_san_pham'=> 'Xiaomi 11T Pro 5G',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cây lấy sim, Ốp lưng, Cáp Type C, Củ sạc nhanh rời đầu Type A',
            'trang_thai'=> 1,
        ]);
        DienThoai::create([
            'thuong_hieu_id'=> 1,
            'ten_san_pham'=> 'iPhone 12 Pro',
            'mo_ta'=> 'Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cây lấy sim, Cáp Lightning - Type C',
            'trang_thai'=> 1,
        ]);
    }
}
