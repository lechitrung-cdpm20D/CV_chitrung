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
        Schema::create('pin_sacs', function (Blueprint $table) {
            $table->id();
            $table->string('dung_luong_pin',500);
            $table->string('loai_pin',500);
            $table->string('ho_tro_sac_toi_da',500);
            $table->string('sac_kem_theo_may',500);
            $table->string('cong_nghe_pin',500);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pin_sacs');
    }
};
