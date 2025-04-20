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
        Schema::create('check_out_tools', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users");

            $table->bigInteger('tool_id')->unsigned()->nullable();
            $table->foreign("tool_id")->references("id")->on("tools");


            $table->string('tanggal_pengambilan');
            $table->string('kd_peminjam_tool');


            $table->integer('quantity');
            $table->boolean('status_kembali')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_out_tools');
    }
};
