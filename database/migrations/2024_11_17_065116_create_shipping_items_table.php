<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('shipping_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('kd_sj_brg_keluar')->unique();
            $table->string('date_delivery')->nullable();
            $table->string('to')->nullable();
            $table->enum('status', ['draft', 'shipped']);
            $table->string('description_stuff')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_items');
    }
};
