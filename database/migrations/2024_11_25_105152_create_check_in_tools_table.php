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
        Schema::create('check_in_tools', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pengembalian');
            $table->string('bagian_divisi');
            $table->string('nama_pengembalian');
            $table->string('kd_pengembalian_alat');

            $table->bigInteger('tool_id')->unsigned()->nullable();
            $table->foreign("tool_id")->references("id")->on('tools');

            $table->integer('quantity');
            $table->string('jenis_quantity');
            $table->string('keterangan_alat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_in_tools');
    }
};
