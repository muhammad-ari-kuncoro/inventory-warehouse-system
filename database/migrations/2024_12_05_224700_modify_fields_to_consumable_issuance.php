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
        Schema::table('consumable_issuance', function (Blueprint $table) {
            $table->dropColumn('nama_pengambil');
            $table->dropColumn('bagian_divisi');

            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consumable_issuance', function (Blueprint $table) {
            $table->string('nama_pengambil');
            $table->string('bagian_divisi');

            $table->dropColumn('user_id');
        });
    }
};
