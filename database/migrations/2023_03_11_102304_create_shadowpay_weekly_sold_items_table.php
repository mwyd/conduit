<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shadowpay_weekly_sold_items', function (Blueprint $table) {
            $table->id();
            $table->string('hash_name');
            $table->tinyInteger('discount', false, true);
            $table->decimal('price', 7, 2, true)->nullable();
            $table->dateTime('sold_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shadowpay_weekly_sold_items');
    }
};
