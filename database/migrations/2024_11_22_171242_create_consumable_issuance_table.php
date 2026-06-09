<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('consumable_issuance_header', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users");
            $table->string('kd_consumable_out')->nullable();
            $table->string('transaction_date_out')->nullable();
            $table->enum('status',['draft','submitted'])->default('draft');
            $table->string('submitted')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumable_issuance');
    }
};
