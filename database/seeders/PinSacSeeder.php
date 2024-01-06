<?php

namespace Database\Seeders;

use App\Models\Pin_Sac;
use Illuminate\Database\Seeder;

class PinSacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pin_Sac::create([
            'dung_luong_pin'=> '4310 mAh',
            'loai_pin'=> 'Li-Po',
            'ho_tro_sac_toi_da'=> '30 W',
            'sac_kem_theo_may'=> '30 W',
            'cong_nghe_pin'=>'Sạc nhanh VOOC',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '4352 mAh',
            'loai_pin'=> 'Li-Ion',
            'ho_tro_sac_toi_da'=> '20 W',
            'sac_kem_theo_may'=> 'Không có',
            'cong_nghe_pin'=>'Siêu tiết kiệm pin - Sạc không dây - Sạc không dây MagSafe - Sạc pin nhanh',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '5000 mAh',
            'loai_pin'=> 'Li-Ion',
            'ho_tro_sac_toi_da'=> '45 W',
            'sac_kem_theo_may'=> 'Không có',
            'cong_nghe_pin'=>'Sạc không dây - Sạc ngược không dây - Sạc pin nhanh',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '4050 mAh',
            'loai_pin'=> 'Li-Po',
            'ho_tro_sac_toi_da'=> '44 W',
            'sac_kem_theo_may'=> '44 W',
            'cong_nghe_pin'=>'Sạc pin nhanh - Tiết kiệm pin',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '4500 mAh',
            'loai_pin'=> 'Li-Ion',
            'ho_tro_sac_toi_da'=> '67 W',
            'sac_kem_theo_may'=> '67 W',
            'cong_nghe_pin'=>'Sạc không dây - Sạc ngược không dây - Sạc pin nhanh - Tiết kiệm pin',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '5000 mAh',
            'loai_pin'=> 'Li-Po',
            'ho_tro_sac_toi_da'=> '33 W',
            'sac_kem_theo_may'=> '33 W',
            'cong_nghe_pin'=>'Siêu tiết kiệm pin - Sạc pin nhanh',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '5050 mAh',
            'loai_pin'=> 'Li-Ion',
            'ho_tro_sac_toi_da'=> '18 W',
            'sac_kem_theo_may'=> '10 W',
            'cong_nghe_pin'=>'Sạc pin nhanh',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '4000 mAh',
            'loai_pin'=> 'Li-Ion',
            'ho_tro_sac_toi_da'=> '5 W',
            'sac_kem_theo_may'=> '5 W',
            'cong_nghe_pin'=>'Không có',
        ]);
        Pin_Sac::create([
            'dung_luong_pin'=> '2000 mAh',
            'loai_pin'=> 'Li-Ion',
            'ho_tro_sac_toi_da'=> 'Không có',
            'sac_kem_theo_may'=> '2.5 W',
            'cong_nghe_pin'=>'Không có',
        ]);
    }
}
