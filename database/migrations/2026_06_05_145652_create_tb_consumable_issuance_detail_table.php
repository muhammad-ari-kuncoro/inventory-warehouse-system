<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('consumable_issuance_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('header_id')->unsigned()->nullable();
            $table->foreign("header_id")->references("id")->on("consumable_issuance_header");
            $table->bigInteger('consumable_id')->unsigned()->nullable();
            $table->foreign("consumable_id")->references("id")->on("consumables");
            $table->integer('quantity');
            $table->string('type_quantity');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumable_issuance_details');
    }
};
