<?php

namespace Database\Seeders;

use App\Models\ChiTietDonHang;
use Illuminate\Database\Seeder;

class ChiTietDonHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //2022
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20220101',
            'chi_tiet_dien_thoai_id' => 1,
            'gia' => 8900000,
            'gia_giam' => 8010000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20220101',
            'chi_tiet_dien_thoai_id' => 3,
            'gia' => 33590000,
            'gia_giam' => 30231000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20220201',
            'chi_tiet_dien_thoai_id' => 5,
            'gia' => 30990000,
            'gia_giam' => 27891000,
            'so_luong' => 35,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20220201',
            'chi_tiet_dien_thoai_id' => 7,
            'gia' => 8490000,
            'gia_giam' => 7641000,
            'so_luong' => 8,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20220301',
            'chi_tiet_dien_thoai_id' => 9,
            'gia' => 19900000,
            'gia_giam' => 19900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20220301',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20220401',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20220401',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 22,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHPPOOII20220501',
            'chi_tiet_dien_thoai_id' => 16,
            'gia' => 750000,
            'gia_giam' => 750000,
            'so_luong' => 60,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHPPOOII20220501',
            'chi_tiet_dien_thoai_id' => 16,
            'gia' => 750000,
            'gia_giam' => 750000,
            'so_luong' => 80,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20220601',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 50,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20220601',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 58,
        ]);
        //2021
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20210101',
            'chi_tiet_dien_thoai_id' => 1,
            'gia' => 8900000,
            'gia_giam' => 8010000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20210101',
            'chi_tiet_dien_thoai_id' => 3,
            'gia' => 33590000,
            'gia_giam' => 30231000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20210201',
            'chi_tiet_dien_thoai_id' => 5,
            'gia' => 30990000,
            'gia_giam' => 27891000,
            'so_luong' => 35,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20210201',
            'chi_tiet_dien_thoai_id' => 7,
            'gia' => 8490000,
            'gia_giam' => 7641000,
            'so_luong' => 8,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20210301',
            'chi_tiet_dien_thoai_id' => 9,
            'gia' => 19900000,
            'gia_giam' => 19900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20210301',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20210401',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20210401',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 22,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHPPOOII20210501',
            'chi_tiet_dien_thoai_id' => 16,
            'gia' => 750000,
            'gia_giam' => 750000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20210601',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20210601',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHZZJJKK20210701',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHZZJJKK20210701',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHKK20210801',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 30,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHKK20210801',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20210901',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20211001',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 50,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20211101',
            'chi_tiet_dien_thoai_id' => 9,
            'gia' => 19900000,
            'gia_giam' => 19900000,
            'so_luong' => 55,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20211201',
            'chi_tiet_dien_thoai_id' => 3,
            'gia' => 33590000,
            'gia_giam' => 30231000,
            'so_luong' => 40,
        ]);
        //2020
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20200101',
            'chi_tiet_dien_thoai_id' => 1,
            'gia' => 8900000,
            'gia_giam' => 8010000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20200201',
            'chi_tiet_dien_thoai_id' => 5,
            'gia' => 30990000,
            'gia_giam' => 27891000,
            'so_luong' => 35,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20200301',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20200401',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 22,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHPPOOII20200501',
            'chi_tiet_dien_thoai_id' => 16,
            'gia' => 750000,
            'gia_giam' => 750000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20200601',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHZZJJKK20200701',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHKK20200801',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20200901',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20201001',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 50,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20201101',
            'chi_tiet_dien_thoai_id' => 9,
            'gia' => 19900000,
            'gia_giam' => 19900000,
            'so_luong' => 55,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20201201',
            'chi_tiet_dien_thoai_id' => 3,
            'gia' => 33590000,
            'gia_giam' => 30231000,
            'so_luong' => 40,
        ]);
        //2019
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20190101',
            'chi_tiet_dien_thoai_id' => 1,
            'gia' => 8900000,
            'gia_giam' => 8010000,
            'so_luong' => 38,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20190201',
            'chi_tiet_dien_thoai_id' => 5,
            'gia' => 30990000,
            'gia_giam' => 27891000,
            'so_luong' => 55,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20190301',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 25,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20190401',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 42,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHPPOOII20190501',
            'chi_tiet_dien_thoai_id' => 16,
            'gia' => 750000,
            'gia_giam' => 750000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20190601',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 38,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHZZJJKK20190701',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHKK20190801',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 80,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20190901',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 18,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20191001',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20191101',
            'chi_tiet_dien_thoai_id' => 9,
            'gia' => 19900000,
            'gia_giam' => 19900000,
            'so_luong' => 35,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20191201',
            'chi_tiet_dien_thoai_id' => 3,
            'gia' => 33590000,
            'gia_giam' => 30231000,
            'so_luong' => 10,
        ]);
        //2018
        ChiTietDonHang::create([
            'don_hang_id' => 'DHAABBCC20180101',
            'chi_tiet_dien_thoai_id' => 1,
            'gia' => 8900000,
            'gia_giam' => 8010000,
            'so_luong' => 18,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHCCDDEE20180201',
            'chi_tiet_dien_thoai_id' => 5,
            'gia' => 30990000,
            'gia_giam' => 27891000,
            'so_luong' => 45,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHQQWWEE20180301',
            'chi_tiet_dien_thoai_id' => 10,
            'gia' => 7900000,
            'gia_giam' => 7900000,
            'so_luong' => 55,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHRRTTYY20180401',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 12,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHPPOOII20180501',
            'chi_tiet_dien_thoai_id' => 16,
            'gia' => 750000,
            'gia_giam' => 750000,
            'so_luong' => 10,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHHHJJKK20180601',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 18,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHZZJJKK20180701',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 20,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHKK20180801',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 50,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20180901',
            'chi_tiet_dien_thoai_id' => 12,
            'gia' => 4200000,
            'gia_giam' => 4200000,
            'so_luong' => 28,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20181001',
            'chi_tiet_dien_thoai_id' => 14,
            'gia' => 2290000,
            'gia_giam' => 2290000,
            'so_luong' => 30,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20181101',
            'chi_tiet_dien_thoai_id' => 9,
            'gia' => 19900000,
            'gia_giam' => 19900000,
            'so_luong' => 15,
        ]);
        ChiTietDonHang::create([
            'don_hang_id' => 'DHLLHHMM20181201',
            'chi_tiet_dien_thoai_id' => 3,
            'gia' => 33590000,
            'gia_giam' => 30231000,
            'so_luong' => 20,
        ]);
    }
}
