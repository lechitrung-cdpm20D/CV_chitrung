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
        Schema::create('tien_iches', function (Blueprint $table) {
            $table->id();
            $table->string('bao_mat_nang_cao',500);
            $table->string('tinh_nang_dac_biet',500);
            $table->string('khang_nuoc_bui',500);
            $table->string('ghi_am',500);
            $table->string('xem_phim',500);
            $table->string('nghe_nhac',500);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tien_iches');
    }
};
