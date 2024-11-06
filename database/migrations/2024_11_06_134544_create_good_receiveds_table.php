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
            $table->string('tanggal_masuk');
            $table->string('no_transaksi');
            $table->string('nama_supplier');
            $table->string('kode_surat_jalan');
            $table->string('nama_barang');
            $table->string('spesifikasi_barang');
            $table->integer('quantity');
            $table->string('jenis_stok');
            $table->string('keterangan_barang');
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
