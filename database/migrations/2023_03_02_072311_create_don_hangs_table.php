<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->string('ma_don_hang')->primary();
            
            $table->string('ho_ten_nguoi_nhan');
            $table->string('dia_chi_nhan_hang');
            $table->string('so_dien_thoai_nguoi_nhan');
            $table->string('ghi_chu')->nullable();
            $table->integer('phuong_thuc_nhan_hang');
            $table->integer('phuong_thuc_thanh_toan');
            $table->date('ngay_giao')->nullable();
            $table->date('ngay_tao');
            $table->integer('trang_thai_thanh_toan');
            $table->integer('trang_thai_don_hang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};
