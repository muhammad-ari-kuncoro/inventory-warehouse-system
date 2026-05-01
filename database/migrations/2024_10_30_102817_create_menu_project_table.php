<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_project', function (Blueprint $table) {
            $table->id();
            $table->string('nama_project');
            $table->string('sub_nama_project');
            $table->string('kategori_project');
            $table->string('no_jo_project');
            $table->string('kode_project');
            $table->string('no_po_project');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_project');
    }
};
