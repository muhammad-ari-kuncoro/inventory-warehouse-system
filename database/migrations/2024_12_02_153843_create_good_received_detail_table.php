<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('good_received_detail', function (Blueprint $table) {
            $table->id();


            $table->integer('good_received_id')->nullable();;
            $table->bigInteger('material_id')->unsigned()->nullable();
            $table->foreign("material_id")->references("id")->on("materials");
            $table->bigInteger('consumable_id')->unsigned()->nullable();
            $table->foreign("consumable_id")->references("id")->on("consumables");
            $table->bigInteger('machine_id')->unsigned()->nullable();
            $table->foreign("machine_id")->references("id")->on("machine_assets");
            $table->string('jenis_barang');
            $table->integer('quantity');
            $table->string('quantity_jenis');
            $table->string('keterangan_barang')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('good_received_detail');
    }
};
