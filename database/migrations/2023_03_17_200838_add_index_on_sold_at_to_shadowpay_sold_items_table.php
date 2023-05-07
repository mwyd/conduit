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
        Schema::table('shadowpay_sold_items', function (Blueprint $table) {
            $table->index('sold_at', 'sold_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shadowpay_sold_items', function (Blueprint $table) {
            $table->dropIndex('sold_at_index');
        });
    }
};
