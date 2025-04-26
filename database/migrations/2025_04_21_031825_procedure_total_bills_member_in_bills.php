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
        // Schema::table('bills', function (Blueprint $table) {
        //     //
        // });
        DB::unprepared("
            CREATE FUNCTION total_bills_by_member(p_member_id BIGINT)
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE total INT;

                SELECT COUNT(*) INTO total
                FROM bills
                WHERE members_id = p_member_id;

                RETURN total;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('bills', function (Blueprint $table) {
        //     //
        // });

        DB::unprepared("DROP FUNCTION IF EXISTS total_bills_by_member");
    }
};
