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
        Schema::create('chi_tiet_khos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kho_id');
            $table->foreignId('chi_tiet_dien_thoai_id');
            $table->integer('so_luong');
            $table->date('ngay_nhap');
            $table->timestamps();
            $table->foreign('kho_id')->references('id')->on('khos');
            $table->foreign('chi_tiet_dien_thoai_id')->references('id')->on('chi_tiet_dien_thoais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_khos');
    }
};
