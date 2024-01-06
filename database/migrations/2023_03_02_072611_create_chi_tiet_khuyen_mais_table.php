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
        Schema::create('chi_tiet_khuyen_mais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khuyen_mai_id');
            $table->foreignId('dien_thoai_id');
            $table->double('phan_tram_giam');
            $table->timestamps();
            $table->foreign('khuyen_mai_id')->references('id')->on('khuyen_mais');
            $table->foreign('dien_thoai_id')->references('id')->on('dien_thoais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_khuyen_mais');
    }
};
