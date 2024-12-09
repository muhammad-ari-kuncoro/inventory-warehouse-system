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
        Schema::create('material_temporaries', function (Blueprint $table) {
            $table->id();
            $table->string('nm_material_temporary');
            $table->string('kd_material_temporary');
            $table->string('spesifikasi_material_temporary');
            $table->integer('quantity_temporary');
            $table->string('jenis_quantity');
            $table->string('jenis_material');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_temporaries');
    }
};
