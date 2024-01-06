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
        Schema::create('he_dieu_hanh_c_p_u_s', function (Blueprint $table) {
            $table->id();
            $table->string('he_dieu_hanh',500);
            $table->string('chip_xu_ly',500);
            $table->string('toc_do_cpu',500);
            $table->string('chip_do_hoa',500);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('he_dieu_hanh_c_p_u_s');
    }
};
