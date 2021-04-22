<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShadowpaySoldItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shadowpay_sold_items', function (Blueprint $table) {
            $table->string('transaction_id', 16)->primary();
            $table->string('hash_name');
            $table->tinyInteger('discount', false, true);
            $table->mediumInteger('sell_price', false, true)->nullable();
            $table->mediumInteger('steam_price', false, true)->nullable();
            $table->dateTime('sold_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shadowpay_sold_items');
    }
}
