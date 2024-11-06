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
        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->string('nama_consumable');
            $table->string('spesifikasi_consumable');
            $table->string('kode_consumable');
            $table->string('jenis_quantity');
            $table->integer('quantity');
            $table->string('jenis_consumable');
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->foreign("project_id")->references("id")->on("menu_project");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumables');
    }
};
