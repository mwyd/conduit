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
            $table->decimal('sell_price', 7, 2, true)->nullable();
            $table->decimal('steam_price', 7, 2, true)->nullable();
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
