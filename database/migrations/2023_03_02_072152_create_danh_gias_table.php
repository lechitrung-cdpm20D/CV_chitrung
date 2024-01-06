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
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tai_khoan_id');
            $table->foreignId('dien_thoai_id');
            $table->string('noi_dung');
            $table->integer('so_sao');
            $table->integer('trang_thai');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tai_khoan_id')->references('id')->on('tai_khoans');
            $table->foreign('dien_thoai_id')->references('id')->on('dien_thoais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};
