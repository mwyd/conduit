<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShadowpaySaleGuardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shadowpay_sale_guard_items', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('user_id');
            $table->integer('shadowpay_item_id')->unique();
            $table->decimal('min_price', 7, 2);
            $table->decimal('max_price', 7, 2);
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
        Schema::dropIfExists('shadowpay_sale_guard_items');
    }
}
