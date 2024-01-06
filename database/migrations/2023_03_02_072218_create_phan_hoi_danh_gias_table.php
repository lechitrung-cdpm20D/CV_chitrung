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
        Schema::create('phan_hoi_danh_gias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danh_gia_id');
            $table->foreignId('tai_khoan_id');
            $table->string('noi_dung');
            $table->string('trang_thai');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('danh_gia_id')->references('id')->on('danh_gias');
            $table->foreign('tai_khoan_id')->references('id')->on('tai_khoans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_hoi_danh_gias');
    }
};
