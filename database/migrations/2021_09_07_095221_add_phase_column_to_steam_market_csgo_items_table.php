<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhaseColumnToSteamMarketCsgoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->string('phase', 16)->nullable()->after('exterior');
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
            $table->dropColumn('phase');
        });
    }
}
