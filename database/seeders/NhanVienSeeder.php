<?php

namespace Database\Seeders;

use App\Models\NhanVien;
use Illuminate\Database\Seeder;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NhanVien::create([
            'chuc_vu_id'=> 1,
            'quan_ly_id'=> null,
            'tai_khoan_id'=> 1,
            'cua_hang_id'=> 1,
            'kho_id'=> 1,
            'ho_ten'=> 'Nguyễn Hoàng Vũ',
            'dia_chi'=> '497 Thống Nhất, phường 16, Gò Vấp, Hồ Chí Minh',
            'ngay_sinh'=> '2001-1-1',
            'gioi_tinh'=> 1,
            'so_dien_thoai'=> '0123456785',
            'cccd'=> '079201026785',
            'bhxh'=> '0123456785',
        ]);
        NhanVien::create([
            'chuc_vu_id'=> 1,
            'quan_ly_id'=> 1,
            'tai_khoan_id'=> 2,
            'cua_hang_id'=> 2,
            'kho_id'=> 1,
            'ho_ten'=> 'Trương Văn Phú',
            'dia_chi'=> '11 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'ngay_sinh'=> '1995-1-1',
            'gioi_tinh'=> 1,
            'so_dien_thoai'=> '0123456780',
            'cccd'=> '079201026789',
            'bhxh'=> '0123456789',
        ]);

        NhanVien::create([
            'chuc_vu_id'=> 2,
            'quan_ly_id'=> 1,
            'tai_khoan_id'=> 3,
            'cua_hang_id'=> 1,
            'kho_id'=> 2,
            'ho_ten'=> 'Lê Nhật Minh',
            'dia_chi'=> '18 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'ngay_sinh'=> '1996-1-1',
            'gioi_tinh'=> 1,
            'so_dien_thoai'=> '0123456781',
            'cccd'=> '079201026780',
            'bhxh'=> '0123456780',
        ]);

        NhanVien::create([
            'chuc_vu_id'=> 3,
            'quan_ly_id'=> 2,
            'tai_khoan_id'=> 4,
            'cua_hang_id'=> 2,
            'kho_id'=> 1,
            'ho_ten'=> 'Hoàng Phương Phi',
            'dia_chi'=> '28 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 1,
            'so_dien_thoai'=> '0123456729',
            'cccd'=> '079201026787',
            'bhxh'=> '0123456785',
        ]);

        NhanVien::create([
            'chuc_vu_id'=> 3,
            'quan_ly_id'=> 2,
            'tai_khoan_id'=> 5,
            'cua_hang_id'=> 2,
            'kho_id'=> 1,
            'ho_ten'=> 'Hoàng Phương Ly',
            'dia_chi'=> '28 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 0,
            'so_dien_thoai'=> '0123456722',
            'cccd'=> '079201026784',
            'bhxh'=> '0123456784',
        ]);

        NhanVien::create([
            'chuc_vu_id'=> 3,
            'quan_ly_id'=> 3,
            'tai_khoan_id'=> 6,
            'cua_hang_id'=> 1,
            'kho_id'=> 2,
            'ho_ten'=> 'Lương Lư Vương',
            'dia_chi'=> '29 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 1,
            'so_dien_thoai'=> '0123456702',
            'cccd'=> '079201026788',
            'bhxh'=> '0123456788',
        ]);

        NhanVien::create([
            'chuc_vu_id'=> 3,
            'quan_ly_id'=> 3,
            'tai_khoan_id'=> 7,
            'cua_hang_id'=> 1,
            'kho_id'=> 2,
            'ho_ten'=> 'Lương Lư Hà',
            'dia_chi'=> '29 Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'ngay_sinh'=> '1997-1-1',
            'gioi_tinh'=> 0,
            'so_dien_thoai'=> '0123456712',
            'cccd'=> '079201026778',
            'bhxh'=> '0123456778',
        ]);
    }
}
