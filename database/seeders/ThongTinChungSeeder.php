<?php

namespace Database\Seeders;

use App\Models\ThongTinChung;
use Illuminate\Database\Seeder;

class ThongTinChungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung hợp kim & Mặt lưng thuỷ tinh hữu cơ',
            'kich_thuoc_khoi_luong'=> 'Dài 160.2 mm - Ngang 73.38 mm - Dày 7.97 mm - Nặng 173 g',
            'thoi_diem_ra_mat'=> '2021-01-07',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung thép không gỉ & Mặt lưng kính cường lực',
            'kich_thuoc_khoi_luong'=> 'Dài 160.8 mm - Ngang 78.1 mm - Dày 7.65 mm - Nặng 240 g',
            'thoi_diem_ra_mat'=> '2021-01-09',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung kim loại & Mặt lưng kính',
            'kich_thuoc_khoi_luong'=> 'Dài 163.3 mm - Ngang 77.9 mm - Dày 8.9 mm - Nặng 228 g',
            'thoi_diem_ra_mat'=> '2022-02-01',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung nhựa & Mặt lưng kính',
            'kich_thuoc_khoi_luong'=> 'Dài 160.87 mm - Ngang 74.28 mm - Dày 7.41 mm - Nặng 172 g',
            'thoi_diem_ra_mat'=> '2021-11-01',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung kim loại & Mặt lưng kính',
            'kich_thuoc_khoi_luong'=> 'Dài 152.7 mm - Ngang 69.9 mm - Dày 8.2 mm - Nặng 180 g',
            'thoi_diem_ra_mat'=> '2022-03-01',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung nhựa, kim loại & Mặt lưng nhựa',
            'kich_thuoc_khoi_luong'=> 'Dài 164.3 mm - Ngang 75.6 mm - Dày 8.5 mm - Nặng 195 g',
            'thoi_diem_ra_mat'=> '2022-03-01',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Nguyên khối',
            'chat_lieu'=> 'Khung kim loại & Mặt lưng nhựa',
            'kich_thuoc_khoi_luong'=> 'Dài 164.6 mm - Ngang 75.9 mm - Dày 8.5 mm - Nặng 190 g',
            'thoi_diem_ra_mat'=> '2022-04-01',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Pin rời',
            'chat_lieu'=> 'Khung nhôm & Mặt lưng nhựa',
            'kich_thuoc_khoi_luong'=> 'Dài 166 mm - Ngang 75.9 mm - Dày 8.55 mm - Nặng 179 g',
            'thoi_diem_ra_mat'=> '2021-10-01',
        ]);
        ThongTinChung::create([
            'thiet_ke'=> 'Pin rời',
            'chat_lieu'=> 'Khung kim loại & Mặt lưng nhựa',
            'kich_thuoc_khoi_luong'=> 'Dài 125.9 mm - Ngang 57.1 mm - Dày 15.3 mm - Nặng 146.2 g',
            'thoi_diem_ra_mat'=> '2021-12-01',
        ]);
    }
}
