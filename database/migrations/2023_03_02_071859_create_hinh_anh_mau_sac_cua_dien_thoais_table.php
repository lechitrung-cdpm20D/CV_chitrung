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
        Schema::create('hinh_anh_mau_sac_cua_dien_thoais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dien_thoai_id');
            $table->foreignId('mau_sac_id');
            $table->string('hinh_anh');
            $table->integer('hinh_anh_dai_dien');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('dien_thoai_id')->references('id')->on('dien_thoais');
            $table->foreign('mau_sac_id')->references('id')->on('mau_sacs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_mau_sac_cua_dien_thoais');
    }
};
