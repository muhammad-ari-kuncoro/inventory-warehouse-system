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
        Schema::create('hydrotest_material_lending', function (Blueprint $table) {
            $table->id();
            $table->string('tgl_pinjam_material');
            $table->string('bagian_divisi');
            $table->string('nama_peminjam');
            $table->string('kd_hydrotest_material_lending');

            // $table->bigInteger('id_material_temporaries')->unsigned();
            // $table->foreign('id_material_temporaries')->references('id')->on('material_temporaries');


            $table->string('quantity');
            $table->string('jenis_quantity');
            $table->string('jenis_material');
            $table->string('keterangan_material');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hydrotest_material_lending');
    }
};
