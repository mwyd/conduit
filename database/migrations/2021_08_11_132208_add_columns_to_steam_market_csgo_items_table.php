<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSteamMarketCsgoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->boolean('is_stattrak')->after('icon');
            $table->string('name_color', 7)->after('is_stattrak');
            $table->string('exterior', 2)->nullable()->after('name_color');
            $table->string('type')->after('exterior');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->dropColumn('is_stattrak');
            $table->dropColumn('name_color');
            $table->dropColumn('exterior');
            $table->dropColumn('type');
        });
    }
}
