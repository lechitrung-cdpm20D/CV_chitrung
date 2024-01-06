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
        Schema::create('tai_khoans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loai_tai_khoan_id');
            $table->foreignId('bac_tai_khoan_id');
            $table->string('username')->unique();
            $table->integer('diem_thuong');
            $table->string('password');
            $table->string('token');
            $table->integer('trang_thai');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('loai_tai_khoan_id')->references('id')->on('loai_tai_khoans');
            $table->foreign('bac_tai_khoan_id')->references('id')->on('bac_tai_khoans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_khoans');
    }
};
