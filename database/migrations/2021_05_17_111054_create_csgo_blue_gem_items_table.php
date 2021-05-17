<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsgoBlueGemItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csgo_blue_gem_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_type');
            $table->mediumInteger('paint_seed');
            $table->string('gem_type');
            $table->unique(['item_type', 'paint_seed']);
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
        Schema::dropIfExists('csgo_blue_gem_items');
    }
}
