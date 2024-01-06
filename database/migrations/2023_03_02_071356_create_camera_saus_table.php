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
        Schema::create('camera_saus', function (Blueprint $table) {
            $table->id();
            $table->string('do_phan_giai',500);
            $table->string('quay_phim',500);
            $table->string('den_flash',500);
            $table->string('tinh_nang',500);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camera_saus');
    }
};
