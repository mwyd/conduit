<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconLargeColumnToSteamMarketCsgoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->string('icon_large')->nullable()->after('icon');
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
            $table->dropColumn('icon_large');
        });
    }
}
