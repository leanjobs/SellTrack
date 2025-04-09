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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branches_id')->constrained('branches', 'id');
            $table->decimal('total_price', 10,2);
            $table->decimal('tax', 10,2);
            $table->decimal('grand_total', 10,2);
            $table->foreignId('members_id')->nullable()->constrained('members', 'id');
            $table->foreignId('payments_id')->constrained('payments', 'id');
            $table->foreignId('users_id')->constrained('users', 'id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
