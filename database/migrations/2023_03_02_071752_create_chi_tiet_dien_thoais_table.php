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
        Schema::create('chi_tiet_dien_thoais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dien_thoai_id');
            $table->foreignId('man_hinh_id');
            $table->foreignId('camera_sau_id');
            $table->foreignId('camera_truoc_id');
            $table->foreignId('he_dieu_hanh_cpu_id');
            $table->foreignId('bo_nho_luu_tru_id');
            $table->foreignId('ket_noi_id');
            $table->foreignId('pin_sac_id');
            $table->foreignId('tien_ich_id');
            $table->foreignId('thong_tin_chung_id');
            $table->foreignId('mau_sac_id');
            $table->double('gia');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('dien_thoai_id')->references('id')->on('dien_thoais');
            $table->foreign('man_hinh_id')->references('id')->on('man_hinhs');
            $table->foreign('camera_sau_id')->references('id')->on('camera_saus');
            $table->foreign('camera_truoc_id')->references('id')->on('camera_truocs');
            $table->foreign('he_dieu_hanh_cpu_id')->references('id')->on('he_dieu_hanh_cpus');
            $table->foreign('bo_nho_luu_tru_id')->references('id')->on('bo_nho_luu_trus');
            $table->foreign('ket_noi_id')->references('id')->on('ket_nois');
            $table->foreign('pin_sac_id')->references('id')->on('pin_sacs');
            $table->foreign('tien_ich_id')->references('id')->on('tien_iches');
            $table->foreign('thong_tin_chung_id')->references('id')->on('thong_tin_chungs');
            $table->foreign('mau_sac_id')->references('id')->on('mau_sacs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_dien_thoais');
    }
};
