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
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->boolean('is_souvenir')->after('is_stattrak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->dropColumn('is_souvenir');
        });
    }
};
