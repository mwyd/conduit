<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsgoRarePaintSeedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csgo_rare_paint_seed_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumInteger('paint_seed');
            $table->string('variant');
            $table->unique(['name', 'paint_seed']);
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
        Schema::dropIfExists('csgo_rare_paint_seed_items');
    }
}
