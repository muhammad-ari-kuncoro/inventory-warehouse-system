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
        Schema::create('consumable_issuance', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pengambilan');
            $table->string('nama_pengambil');
            $table->string('kd_consumable_item');

            $table->bigInteger('consumable_id')->unsigned()->nullable();
            $table->foreign("consumable_id")->references("id")->on("consumables");

            $table->integer('quantity');
            $table->string('jenis_quantity');
            $table->string('keterangan_consumable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumable_issuance');
    }
};
