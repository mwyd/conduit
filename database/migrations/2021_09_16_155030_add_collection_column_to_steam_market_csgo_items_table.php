<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollectionColumnToSteamMarketCsgoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steam_market_csgo_items', function (Blueprint $table) {
            $table->string('collection')->nullable()->after('phase');
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
            $table->dropColumn('collection');
        });
    }
}
