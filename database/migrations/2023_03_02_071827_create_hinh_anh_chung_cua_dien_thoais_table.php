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
        Schema::create('hinh_anh_chung_cua_dien_thoais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dien_thoai_id');
            $table->string('hinh_anh');
            $table->integer('loai_hinh');//0 là hình đại diện, 1 là hình giới thiệu chung, 2 là hình mở hộp, ...
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('dien_thoai_id')->references('id')->on('dien_thoais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_chung_cua_dien_thoais');
    }
};
