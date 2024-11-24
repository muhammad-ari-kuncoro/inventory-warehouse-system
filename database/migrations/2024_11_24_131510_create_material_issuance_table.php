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
        Schema::create('material_issuance', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pengambilan');
            $table->string('bagian_divisi');
            $table->string('nama_pengambil');

            $table->string('kd_material_item');
            $table->bigInteger('material_id')->unsigned()->nullable();
            $table->foreign("material_id")->references("id")->on("materials");


            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->foreign("project_id")->references("id")->on('menu_project');

            $table->integer('quantity');
            $table->string('jenis_quantity');
            $table->string('keterangan_material');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_issuance');
    }
};
