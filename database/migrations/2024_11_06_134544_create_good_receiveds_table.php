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
        Schema::create('goods_received', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('tanggal_masuk');
            $table->string('kd_sj');
            $table->string('nama_supplier');
            $table->string('kode_surat_jalan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_received');
    }
};
