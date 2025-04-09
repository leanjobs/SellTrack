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
        Schema::create('incoming_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branches_id')->constrained('branches', 'id');
            $table->foreignId('products_id')->constrained('products', 'id');
            $table->integer('initial_stocks');
            $table->integer('current_stocks');
            $table->date('expired');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_stocks');
    }
};
