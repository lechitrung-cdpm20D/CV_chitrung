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
        Schema::create('cham_congs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nhan_vien_id');
            $table->string('he_so_luong_id');
            $table->string('thuong_id');
            $table->string('phu_cap_id');
            $table->integer('thang');
            $table->integer('nam');
            $table->integer('so_ngay_lam_viec');
            $table->double('ung_truoc');
            $table->timestamps();
            $table->foreign('nhan_vien_id')->references('id')->on('nhan_viens');
            $table->foreign('he_so_luong_id')->references('ma_hsl')->on('he_so_luongs');
            $table->foreign('phu_cap_id')->references('ma_phu_cap')->on('phu_caps');
            $table->foreign('thuong_id')->references('ma_thuong')->on('thuongs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cham_congs');
    }
};
