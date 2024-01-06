<?php

namespace Database\Seeders;

use App\Models\KetNoi;
use Illuminate\Database\Seeder;

class KetNoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 5G',
            'sim' => '2 Nano SIM',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac - Wi-Fi Direct -  Wi-Fi hotspot',
            'gps' => 'GPS - BDS - GALILEO - GLONASS',
            'bluetooth' => 'A2DP - LE - v5.1',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => '3.5 mm',
            'ket_noi_khac' => 'OTG',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 5G',
            'sim' => '1 Nano SIM & 1 eSIM',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac/ax - Wi-Fi hotspot - Wi-Fi MIMO',
            'gps' => 'BEIDOU - QZSS - GALILEO - iBeacon -  GPS - GLONASS',
            'bluetooth' => 'A2DP - LE - v5.0',
            'cong_ket_noi' => 'Lightning',
            'jack_tai_nghe' => 'Lightning',
            'ket_noi_khac' => 'NFC',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 5G',
            'sim' => '2 Nano SIM hoặc 1 Nano SIM + 1 eSIM',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac/ax - Wi-Fi Direct - Wi-Fi hotspot',
            'gps' => 'BEIDOU - GALILEO - GLONASS - GPS - QZSS',
            'bluetooth' => 'v5.2',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => 'Type-C',
            'ket_noi_khac' => 'NFC',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 4G',
            'sim' => '2 Nano SIM (SIM 2 chung khe thẻ nhớ)',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac - Wi-Fi Direct - Wi-Fi hotspot',
            'gps' => 'BEIDOU - GPS - GALILEO - GLONASS',
            'bluetooth' => 'v5.2',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => 'Type-C',
            'ket_noi_khac' => 'OTG',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 5G',
            'sim' => '2 Nano SIM',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac - Wi-Fi Direct -  Wi-Fi hotspot',
            'gps' => 'BEIDOU - GPS - GALILEO - GLONASS',
            'bluetooth' => 'A2DP - LE - v5.2',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => 'Type-C',
            'ket_noi_khac' => 'Hồng ngoại - NFC',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 5G',
            'sim' => '2 Nano SIM (SIM 2 chung khe thẻ nhớ)',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac',
            'gps' => 'BEIDOU - GPS - GLONASS',
            'bluetooth' => 'v5.1',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => '3.5 mm',
            'ket_noi_khac' => 'NFC',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 4G',
            'sim' => '2 Nano SIM',
            'wifi' => 'Dual-band (2.4 GHz/5 GHz) - Wi-Fi 802.11 a/b/g/n/ac',
            'gps' => 'GPS - GALILEO - GLONASS',
            'bluetooth' => 'v5.0',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => '3.5 mm',
            'ket_noi_khac' => 'NFC - OTG',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 4G',
            'sim' => '2 Nano SIM',
            'wifi' => 'Wi-Fi 802.11 b/g/n',
            'gps' => 'GPS',
            'bluetooth' => 'v4.3',
            'cong_ket_noi' => 'Micro USB',
            'jack_tai_nghe' => '3.5 mm',
            'ket_noi_khac' => 'OTG',
        ]);
        KetNoi::create([
            'mang_di_dong' => 'Hỗ trợ 4G VoLTE',
            'sim' => '2 Nano SIM',
            'wifi' => 'Không có',
            'gps' => 'Không có',
            'bluetooth' => 'v4.2',
            'cong_ket_noi' => 'Type-C',
            'jack_tai_nghe' => 'Không có',
            'ket_noi_khac' => 'Không có',
        ]);
    }
}
