<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleGuardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_guard_items', function (Blueprint $table) {
            $table->integer('item_id')->primary();
            $table->mediumInteger('user_id');
            $table->string('hash_name');
            $table->decimal('minimum_price', 7, 2, true);
            $table->decimal('maximum_price', 7, 2, true);
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
        Schema::dropIfExists('sale_guard_items');
    }
}
