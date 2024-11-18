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
        Schema::create('shipping_items', function (Blueprint $table) {
            $table->id();
            $table->string('tgl_kirim');
            $table->string('pengirim');
            $table->string('tujuan');
            $table->string('kd_sj_brg_keluar');
            $table->string('deskripsi_brg');
            $table->integer('quantity');
            $table->string('jenis_quantity');
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->foreign("project_id")->references("id")->on("menu_project");
            $table->string('keterangan_brg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_items');
    }
};
