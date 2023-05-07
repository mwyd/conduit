<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER shadowpay_sold_items_insert_trigger AFTER INSERT ON shadowpay_sold_items
              FOR EACH ROW
              BEGIN
                INSERT INTO shadowpay_weekly_sold_items
                VALUES(NULL, NEW.hash_name, NEW.discount, ROUND((100 - discount) / 100 * NEW.suggested_price, 2), NEW.sold_at);
              END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER shadowpay_sold_items_insert_trigger');
    }
};
