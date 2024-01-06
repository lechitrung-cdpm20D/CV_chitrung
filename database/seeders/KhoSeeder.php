<?php

namespace Database\Seeders;

use App\Models\Kho;
use Illuminate\Database\Seeder;

class KhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kho::create([
            'ten_kho'=> 'Không có',
            'dia_chi'=> 'Không có',
            'google_map'=>null,
        ]);
        Kho::create([
            'ten_kho'=> 'Kho chính',
            'dia_chi'=> '222/1C Lũy Bán Bích, Tân Thành, Tân Phú, Hồ Chí Minh',
            'google_map'=>'https://www.google.com/maps/place/222%2F1C+Lũy+Bán+Bích,+Tân+Thành,+Tân+Phú,+Thành+phố+Hồ+Chí+Minh,+Việt+Nam/@10.788078,106.6322327,17z/data=!3m1!4b1!4m9!1m2!2m1!1zMjIyLzFDIEzFqXkgQsOhbiBCw61jaCwgVMOibiBUaMOgbmgsIFTDom4gUGjDuiwgSOG7kyBDaMOtIE1pbmg!3m5!1s0x31752eac3c5c3eb3:0x4c484830b98fd865!8m2!3d10.788078!4d106.6367174!15sCj4yMjIvMUMgTMWpeSBCw6FuIELDrWNoLCBUw6JuIFRow6BuaCwgVMOibiBQaMO6LCBI4buTIENow60gTWluaJIBEWNvbXBvdW5kX2J1aWxkaW5n?hl=vi-VN',
        ]);
    }
}
