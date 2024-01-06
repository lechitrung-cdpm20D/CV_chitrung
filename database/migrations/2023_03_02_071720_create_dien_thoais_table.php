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
        Schema::create('dien_thoais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thuong_hieu_id');
            $table->string('ten_san_pham',100);
            $table->string('mo_ta',500)->nullable();
            $table->integer('trang_thai');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('thuong_hieu_id')->references('id')->on('thuong_hieus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dien_thoais');
    }
};
