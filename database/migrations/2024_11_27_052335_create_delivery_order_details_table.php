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
        Schema::create('delivery_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_order_id');
            $table->string('item_description');
            $table->string('item_size')->nullable();
            $table->string('item_weight')->nullable();
            $table->string('item_qty')->nullable();
            $table->string('item_measurement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_details');
    }
};
