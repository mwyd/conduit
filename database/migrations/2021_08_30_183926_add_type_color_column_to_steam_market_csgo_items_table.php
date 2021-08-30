<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColorColumnToSteamMarketCsgoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->string('type_color', 7)->after('type');
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
            $table->dropColumn('type_color');
        });
    }
}
