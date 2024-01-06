<?php

namespace Database\Seeders;

use App\Models\BoNho_LuuTru;
use Illuminate\Database\Seeder;

class BoNhoLuuTruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoNho_LuuTru::create([
            'ram'=> '4 GB',
            'bo_nho_trong'=> '128 GB',
            'bo_nho_con_lai'=> '110 GB',
            'the_nho'=>'MicroSD, hỗ trợ tối đa 256 GB',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '6 GB',
            'bo_nho_trong'=> '128 GB',
            'bo_nho_con_lai'=> '113 GB',
            'the_nho'=>'Không có',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '8 GB',
            'bo_nho_trong'=> '128 GB',
            'bo_nho_con_lai'=> '100 GB',
            'the_nho'=>'Không có',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '8 GB',
            'bo_nho_trong'=> '128 GB',
            'bo_nho_con_lai'=> '115 GB',
            'the_nho'=>'MicroSD, hỗ trợ tối đa 1 TB',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '8 GB',
            'bo_nho_trong'=> '256 GB',
            'bo_nho_con_lai'=> '229 GB',
            'the_nho'=>'Không có',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '8 GB',
            'bo_nho_trong'=> '128 GB',
            'bo_nho_con_lai'=> '107 GB',
            'the_nho'=>'MicroSD, hỗ trợ tối đa 256 GB',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '4 GB',
            'bo_nho_trong'=> '128 GB',
            'bo_nho_con_lai'=> '115 GB',
            'the_nho'=>'MicroSD, hỗ trợ tối đa 512 GB',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '3 GB',
            'bo_nho_trong'=> '32 GB',
            'bo_nho_con_lai'=> '22 GB',
            'the_nho'=>'MicroSD, hỗ trợ tối đa 128 GB',
            'danh_ba'=> 'Không giới hạn',
        ]);
        BoNho_LuuTru::create([
            'ram'=> '16 MB',
            'bo_nho_trong'=> '24 MB',
            'bo_nho_con_lai'=> '110 GB',
            'the_nho'=>'MicroSD, hỗ trợ tối đa 32 GB',
            'danh_ba'=> '500 số',
        ]);
    }
}
