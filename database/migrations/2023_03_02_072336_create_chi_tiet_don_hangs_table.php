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
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('don_hang_id');
            $table->foreignId('chi_tiet_dien_thoai_id');
            $table->double('gia');
            $table->double('gia_giam');
            $table->integer('so_luong');
            $table->timestamps();
            $table->foreign('don_hang_id')->references('ma_don_hang')->on('don_hangs');
            $table->foreign('chi_tiet_dien_thoai_id')->references('id')->on('chi_tiet_dien_thoais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hangs');
    }
};
