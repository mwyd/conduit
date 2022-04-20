<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuffMarketCsgoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buff_market_csgo_items', function (Blueprint $table) {
            $table->string('hash_name')->primary();
            $table->mediumInteger('volume', false, true);
            $table->decimal('price', 8, 2, true);
            $table->integer('good_id', false, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buff_market_csgo_items');
    }
}
