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
        Schema::create('machine_assets', function (Blueprint $table) {
            $table->id();
            $table->string('kd_mesin_assets');
            $table->string('nama_mesin');
            $table->string('spesifikasi_mesin');
            $table->string('jenis_mesin');
            $table->integer('quantity');
            $table->string('jenis_quantity');
            $table->string('harga_mesin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_assets');
    }
};
