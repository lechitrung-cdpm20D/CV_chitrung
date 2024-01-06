<?php

namespace Database\Seeders;

use App\Models\HeDieuHanh_CPU;
use Illuminate\Database\Seeder;

class HeDieuHanhCPUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 11',
            'chip_xu_ly' => 'MediaTek Dimensity 800U 5G 8 nhân',
            'toc_do_cpu' => '2 nhân 2.4 GHz & 6 nhân 2 GHz',
            'chip_do_hoa' => 'Mali-G57 MC3',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'iOS 15',
            'chip_xu_ly' => 'Apple A15 Bionic 6 nhân',
            'toc_do_cpu' => '3.22 GHz',
            'chip_do_hoa' => 'Apple GPU 5 nhân',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 12',
            'chip_xu_ly' => 'Snapdragon 8 Gen 1 8 nhân',
            'toc_do_cpu' => '1 nhân 3 GHz, 3 nhân 2.5 GHz & 4 nhân 1.79 GHz',
            'chip_do_hoa' => 'Adreno 730',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 11',
            'chip_xu_ly' => 'MediaTek Helio G96 8 nhân',
            'toc_do_cpu' => '2 nhân 2.05 GHz & 6 nhân 2.0 GHz',
            'chip_do_hoa' => 'Mali-G57 MC2',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 12',
            'chip_xu_ly' => 'Snapdragon 8 Gen 1 8 nhân',
            'toc_do_cpu' => '1 nhân 3 GHz, 3 nhân 2.5 GHz & 4 nhân 1.79 GHz',
            'chip_do_hoa' => 'Adreno 730',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 12',
            'chip_xu_ly' => 'Snapdragon 695 5G 8 nhân',
            'toc_do_cpu' => '2 nhân 2.2 GHz & 6 nhân 1.8 GHz',
            'chip_do_hoa' => 'Adreno 619',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 11',
            'chip_xu_ly' => 'Unisoc T606 8 nhân',
            'toc_do_cpu' => '1.6 GHz',
            'chip_do_hoa' => 'Mali-G57',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Android 10 (Go Edition)',
            'chip_xu_ly' => 'Spreadtrum SC9832E 4 nhân',
            'toc_do_cpu' => '1.4 GHz',
            'chip_do_hoa' => 'Mali-T820 MP1',
        ]);
        HeDieuHanh_CPU::create([
            'he_dieu_hanh' => 'Không có',
            'chip_xu_ly' => 'Unisoc UIS8910',
            'toc_do_cpu' => 'Không có',
            'chip_do_hoa' => 'Không có',
        ]);

    }
}
