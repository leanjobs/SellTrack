<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER update_incoming_stocks_on_payment_failed
            AFTER UPDATE ON payments
            FOR EACH ROW
            BEGIN
              IF NEW.status = "failed" AND OLD.status != "failed" THEN
                UPDATE incoming_stocks
                SET current_stocks = current_stocks + (
                    SELECT SUM(quantity)
                    FROM outgoing_stocks
                    WHERE detail_bills_id IN (
                        SELECT id FROM detail_bills
                        WHERE bills_id = (
                            SELECT id FROM bills WHERE payments_id = NEW.id
                        )
                    )
                    AND outgoing_stocks.incoming_stocks_id = incoming_stocks.id
                )
                WHERE id IN (
                    SELECT incoming_stocks_id
                    FROM outgoing_stocks
                    WHERE detail_bills_id IN (
                        SELECT id FROM detail_bills
                        WHERE bills_id = (
                            SELECT id FROM bills WHERE payments_id = NEW.id
                        )
                    )
                );
            END IF;

            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_incoming_stocks_on_payment_failed");
    }
};
