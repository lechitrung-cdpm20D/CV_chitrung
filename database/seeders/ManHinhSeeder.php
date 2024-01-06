<?php

namespace Database\Seeders;

use App\Models\ManHinh;
use Illuminate\Database\Seeder;

class ManHinhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'AMOLED',
            'do_phan_giai'=> 'Full HD+ (1080 x 2400 Pixels)',
            'man_hinh_rong'=> '6.43" - Tần số quét 60 Hz',
            'do_sang_toi_da'=>'1 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực Corning Gorilla Glass 5',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'OLED',
            'do_phan_giai'=> '1284 x 2778 Pixels',
            'man_hinh_rong'=> '6.7" - Tần số quét 120 Hz',
            'do_sang_toi_da'=>'1200 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực Ceramic Shield',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'Dynamic AMOLED 2X',
            'do_phan_giai'=> '2K+ (1440 x 3088 Pixels)',
            'man_hinh_rong'=> '6.8" - Tần số quét 120 Hz',
            'do_sang_toi_da'=>'1750 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực Corning Gorilla Glass Victus+',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'AMOLED',
            'do_phan_giai'=> 'Full HD+ (1080 x 2400 Pixels)',
            'man_hinh_rong'=> '6.44" - Tần số quét 60 Hz',
            'do_sang_toi_da'=>'570 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'AMOLED',
            'do_phan_giai'=> 'Full HD+ (1080 x 2400 Pixels)',
            'man_hinh_rong'=> '6.28" - Tần số quét 120 Hz',
            'do_sang_toi_da'=>'1100 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực Corning Gorilla Glass Victus',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'IPS LCD',
            'do_phan_giai'=> '1080 x 2412 Pixels',
            'man_hinh_rong'=> '6.6" - Tần số quét 120 Hz',
            'do_sang_toi_da'=>'600 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực Panda',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'TFT LCD',
            'do_phan_giai'=> 'HD+ (720 x 1600 Pixels)',
            'man_hinh_rong'=> '6.5" - Tần số quét 90 Hz',
            'do_sang_toi_da'=>'400 nits',
            'mat_kinh_cam_ung'=> 'Kính cường lực Panda',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'IPS LCD',
            'do_phan_giai'=> 'HD+ (720 x 1600 Pixels)',
            'man_hinh_rong'=> '6.5" - Tần số quét Hãng không công bố',
            'do_sang_toi_da'=>'Hãng không công bố',
            'mat_kinh_cam_ung'=> 'Mặt kính cong 2.5D',
        ]);
        ManHinh::create([
            'cong_nghe_man_hinh'=> 'TFT LCD',
            'do_phan_giai'=> '176 x 220 Pixels',
            'man_hinh_rong'=> '2" - Tần số quét Không có',
            'do_sang_toi_da'=>'Hãng không công bố',
            'mat_kinh_cam_ung'=> 'Không có cảm ứng',
        ]);
    }
}
