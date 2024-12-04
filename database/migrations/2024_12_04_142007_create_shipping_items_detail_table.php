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
        Schema::create('shipping_items_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('shipping_items_id')->nullable();
            $table->string('item_names')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('quantity_type')->nullable();
            $table->string('description_items')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_items_detail');
    }
};
