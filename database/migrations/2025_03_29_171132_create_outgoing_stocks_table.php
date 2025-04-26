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
            Schema::create('outgoing_stocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('incoming_stocks_id')->constrained('incoming_stocks', 'id');
                $table->integer('quantity');
                $table->foreignId('detail_bills_id')->constrained('detail_bills', 'id');
                $table->softDeletes();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_stocks');
    }
};
