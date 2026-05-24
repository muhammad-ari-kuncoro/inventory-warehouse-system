<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_received', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('tanggal_masuk')->nullable();
            $table->enum('status', ['draft', 'received'])->default('draft');
            $table->string('nama_supplier')->nullable();
            $table->string('kode_surat_jalan')->nullable();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->foreign("project_id")->references("id")->on("menu_project");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_received');
    }
};
