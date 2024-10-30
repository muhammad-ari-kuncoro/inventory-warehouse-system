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
        Schema::create('menu_project', function (Blueprint $table) {
            $table->id();
            $table->string('nama_project');
            $table->string('sub_nama_project');
            $table->string('kategori_project');
            $table->string('no_jo_project');
            $table->string('kode_project');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_project');
    }
};
