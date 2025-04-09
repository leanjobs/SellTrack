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
        Schema::create('detail_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branches_id')->constrained('branches','id');
            $table->foreignId('discounts_id')->nullable()->constrained('discounts','id');
            $table->foreignId('bills_id')->constrained('bills','id');
            $table->foreignId('products_id')->constrained('products','id');
            $table->integer('quantity');
            $table->decimal('total_price', 10,2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_bills');
    }
};
