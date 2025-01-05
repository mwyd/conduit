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
        Schema::table('shadowpay_sale_guard_items', function (Blueprint $table) {
            $table->bigInteger('shadowpay_offer_id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shadowpay_sale_guard_items', function (Blueprint $table) {
            $table->integer('shadowpay_offer_id')->unique();
        });
    }
};
