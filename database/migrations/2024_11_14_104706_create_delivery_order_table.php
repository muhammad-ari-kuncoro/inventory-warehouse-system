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
        Schema::create('delivery_order', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pengiriman');
            $table->string('pengirim');
            $table->string('penerima');
            $table->string('delivery_no');
            $table->string('purchase_no');
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->foreign("project_id")->references("id")->on("menu_project");
            $table->string('deskripsi_barang');
            $table->integer('quantity');
            $table->string('jenis_quantity');
            $table->string('keterangan_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order');
    }
};
