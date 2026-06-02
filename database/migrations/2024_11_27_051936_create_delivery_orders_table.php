<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('do_no');
            $table->string('packing_list')->nullable();
            $table->string('delivery_order_no_doc')->nullable();
            $table->enum('status',['draft','shipped']);
            $table->string('do_date')->nullable();
            $table->longText('shipment_address')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
