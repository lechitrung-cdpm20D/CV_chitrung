<?php

namespace Database\Seeders;

use App\Models\ThongTinTaiKhoan;
use Illuminate\Database\Seeder;

class ThongTinTaiKhoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 1,
            'ho_ten'=> 'Nguyễn Hoàng Vũ',
            'dia_chi'=> '497 Thống Nhất, phường 16, Gò Vấp , Hồ Chí Minh',
            'so_dien_thoai'=> '0918111121',
            'email'=> 'admin@gmail.com',
            'ngay_sinh'=> '2001-1-1',
            'gioi_tinh'=> 1,
        ]);
        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 2,
            'ho_ten'=> 'Trương Văn Phú',
            'dia_chi'=> '11 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918111122',
            'email'=> 'quanlycuahang1@gmail.com',
            'ngay_sinh'=> '1995-1-1',
            'gioi_tinh'=> 1,
        ]);
        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 3,
            'ho_ten'=> 'Lê Nhật Minh',
            'dia_chi'=> '18 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918111123',
            'email'=> 'quanlykho1@gmail.com',
            'ngay_sinh'=> '1996-1-1',
            'gioi_tinh'=> 1,
        ]);
        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 4,
            'ho_ten'=> 'Hoàng Phương Phi',
            'dia_chi'=> '28 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918111124',
            'email'=> 'nhanviencuahang1@gmail.com',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 1,
        ]);

        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 5,
            'ho_ten'=> 'Hoàng Phương Ly',
            'dia_chi'=> '28 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918111125',
            'email'=> 'nhanviencuahang2@gmail.com',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 0,
        ]);

        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 6,
            'ho_ten'=> 'Lương Lư Vương',
            'dia_chi'=> '29 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918111126',
            'email'=> 'nhanviencuahang2@gmail.com',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 1,
        ]);

        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 7,
            'ho_ten'=> 'Lương Lư Hà',
            'dia_chi'=> '29 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918111127',
            'email'=> 'nhanviencuahang2@gmail.com',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 0,
        ]);

        ThongTinTaiKhoan::create([
            'tai_khoan_id'=> 8,
            'ho_ten'=> 'Nguyễn Văn Khách Hàng',
            'dia_chi'=> '119 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'so_dien_thoai'=> '0918123456',
            'email'=> '0306191169@caothang.edu.vn',
            'ngay_sinh'=> '2001-1-2',
            'gioi_tinh'=> 1,
        ]);
    }
}
