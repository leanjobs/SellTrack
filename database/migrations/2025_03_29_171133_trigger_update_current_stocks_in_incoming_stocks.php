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
        // Schema::table('incoming_stocks', function (Blueprint $table) {
        //     //
        // });

        DB::unprepared(
            "
                CREATE TRIGGER update_incoming_stocks
                AFTER INSERT ON outgoing_stocks
                FOR EACH ROW
                BEGIN
                    UPDATE incoming_stocks
                    SET current_stocks = current_stocks - NEW.quantity
                    WHERE id = NEW.incoming_stocks_id;
                END;
            "
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('incoming_stocks', function (Blueprint $table) {
        //     //
        // });

        DB::unprepared("DROP TRIGGER IF EXISTS update_incoming_stocks");
    }
};
