<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MauSacSeeder::class,
            ThuongHieuSeeder::class,
            ManHinhSeeder::class,
            CameraSauSeeder::class,
            CameraTruocSeeder::class,
            HeDieuHanhCPUSeeder::class,
            BoNhoLuuTruSeeder::class,
            KetNoiSeeder::class,
            PinSacSeeder::class,
            TienIchSeeder::class,
            ThongTinChungSeeder::class,
            DienThoaiSeeder::class,
            ChiTietDienThoaiSeeder::class,
            HinhAnhBannerTrangChuSeeder::class,
            HinhAnhChungCuaDienThoaiSeeder::class,
            HinhAnhMauSacCuaDienThoaiSeeder::class,
            BacTaiKhoanSeeder::class,
            LoaiTaiKhoanSeeder::class,
            TaiKhoanSeeder::class,
            ThongTinTaiKhoanSeeder::class,
            DanhGiaSeeder::class,
            PhanHoiDanhGiaSeeder::class,
            PhieuGiamGiaSeeder::class,
            DonHangSeeder::class,
            ChiTietDonHangSeeder::class,
            CuaHangSeeder::class,
            SanPhamPhanBoSeeder::class,
            KhoSeeder::class,
            ChiTietKhoSeeder::class,
            KhuyenMaiSeeder::class,
            ChiTietKhuyenMaiSeeder::class,
            ChucVuSeeder::class,
            PhuCapSeeder::class,
            HeSoLuongSeeder::class,
            PhongBanSeeder::class,
            ThuongSeeder::class,
            NhanVienSeeder::class,
            ChamCongSeeder::class,
        ]);
    }
}
