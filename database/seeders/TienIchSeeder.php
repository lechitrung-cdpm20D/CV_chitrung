<?php

namespace Database\Seeders;

use App\Models\TienIch;
use Illuminate\Database\Seeder;

class TienIchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá vân tay dưới màn hình',
            'tinh_nang_dac_biet'=> 'Chạm 2 lần sáng màn hình Ứng dụng kép (Nhân bản ứng dụng)',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm mặc định',
            'xem_phim'=> '3GP - AVI - MP4 - WMV',
            'nghe_nhac'=> 'AAC - AMR - MP3 - WAV - WMA',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt Face ID',
            'tinh_nang_dac_biet'=> 'Không có',
            'khang_nuoc_bui'=> 'IP68',
            'ghi_am'=> 'Ghi âm có microphone chuyên dụng chống ồn',
            'xem_phim'=> 'H.264(MPEG4-AVC)',
            'nghe_nhac'=> 'AAC - FLAC - Lossless',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá vân tay dưới màn hình',
            'tinh_nang_dac_biet'=> 'Chạm 2 lần sáng màn hình - Chặn cuộc gọi - Chặn tin nhắn - Không gian thứ hai (Thư mục bảo mật) -  Màn hình luôn hiển thị AOD - Samsung DeX (Kết nối màn hình sử dụng giao diện tương tự PC) - Samsung Pay - Thu nhỏ màn hình sử dụng một tay - Trợ lý ảo Samsung Bixby - Tối ưu game (Game Booster) - Âm thanh AKG - Âm thanh Dolby Atmos - Đa cửa sổ (chia đôi màn hình)',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm cuộc gọi - Ghi âm mặc định',
            'xem_phim'=> '3GP - AVI - FLV - MKV - MP4',
            'nghe_nhac'=> 'AAC - AMR - M4A - MP3 - OGG - WAV',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá vân tay dưới màn hình',
            'tinh_nang_dac_biet'=> 'Mở rộng bộ nhớ RAM - Tối ưu game (Siêu trò chơi)',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm mặc định',
            'xem_phim'=> '3GP - AVI - MKV - MP4 - FLV',
            'nghe_nhac'=> 'APE - FLAC - Midi - MP2 - MP3 - Vorbis - WAV',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá vân tay dưới màn hình',
            'tinh_nang_dac_biet'=> 'Chạm 2 lần tắt/sáng màn hình - Công nghệ tản nhiệt LiquidCool - Loa kép - Màn hình luôn hiển thị AOD - Âm thanh bởi Harman Kardon - Âm thanh Dolby Atmos - Đa cửa sổ (chia đôi màn hình)',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm cuộc gọi - Ghi âm mặc định',
            'xem_phim'=> 'AVI - MP4',
            'nghe_nhac'=> 'FLAC - Midi - MP3 - OGG',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá vân tay cạnh viền',
            'tinh_nang_dac_biet'=> 'Chế độ trẻ em (Không gian trẻ em) - Chế độ đơn giản (Giao diện đơn giản) - Mở rộng bộ nhớ RAM - Trợ lý ảo Google Assistant',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm mặc định',
            'xem_phim'=> '3GP - AVI - FLV - MKV - MP4 - TS - WMV',
            'nghe_nhac'=> 'AAC - AMR - APE - FLAC - Midi - MP3 - WAV - WMA',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá vân tay cạnh viền',
            'tinh_nang_dac_biet'=> 'Không có',
            'khang_nuoc_bui'=> 'IP52',
            'ghi_am'=> 'Ghi âm mặc định - Hỗ trợ ứng dụng ghi âm',
            'xem_phim'=> 'AVI - MP4',
            'nghe_nhac'=> 'FLAC - Midi - MP3 - OGG',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Mở khoá khuôn mặt - Mở khoá bằng vân tay',
            'tinh_nang_dac_biet'=> 'Không có',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm mặc định',
            'xem_phim'=> '3GP - AVI - MP4',
            'nghe_nhac'=> 'AAC - Midi - MP3 - WAV',
        ]);
        TienIch::create([
            'bao_mat_nang_cao'=> 'Không có',
            'tinh_nang_dac_biet'=> 'Không có',
            'khang_nuoc_bui'=> 'Không có',
            'ghi_am'=> 'Ghi âm mặc định',
            'xem_phim'=> '3GP - MP4',
            'nghe_nhac'=> 'AAC - M4A - MP3',
        ]);
    }
}
