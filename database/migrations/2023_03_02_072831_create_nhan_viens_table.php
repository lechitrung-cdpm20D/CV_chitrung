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
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chuc_vu_id');
            $table->foreignId('quan_ly_id')->nullable();
            $table->foreignId('tai_khoan_id')->nullable();
            $table->foreignId('cua_hang_id');
            $table->foreignId('kho_id');
            $table->string('ho_ten');
            $table->string('dia_chi');
            $table->date('ngay_sinh');
            $table->integer('gioi_tinh');
            $table->string('so_dien_thoai');
            $table->string('cccd');
            $table->string('bhxh');
            $table->timestamps();
            $table->foreign('chuc_vu_id')->references('id')->on('chuc_vus');
            $table->foreign('quan_ly_id')->references('id')->on('nhan_viens');
            $table->foreign('tai_khoan_id')->references('id')->on('tai_khoans');
            $table->foreign('cua_hang_id')->references('id')->on('cua_hangs');
            $table->foreign('kho_id')->references('id')->on('khos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_viens');
    }
};
