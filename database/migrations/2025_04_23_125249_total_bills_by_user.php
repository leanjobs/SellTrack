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
        DB::unprepared("
            CREATE PROCEDURE total_bills_by_user(IN p_users_id BIGINT)
            BEGIN
                DECLARE total INT;

                SELECT COUNT(*) INTO total
                FROM bills
                JOIN payments ON bills.payments_id = payments.id
                WHERE bills.users_id = p_users_id
                AND payments.status = 'succeed';

                SELECT total AS total_transaksi;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS total_bills_by_user");
    }
};
