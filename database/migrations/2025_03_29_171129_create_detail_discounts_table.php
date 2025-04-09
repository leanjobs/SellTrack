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
        Schema::create('detail_discounts', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('discounts_id')->constrained('discounts', 'id');
            $table->foreignId('products_id')->nullable()->constrained('products', 'id');
            $table->integer('min_quantity')->nullable();
            $table->decimal('discount_price', 10,2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->foreignId('free_products_id')->nullable()->constrained('products', 'id');
            $table->integer('quantity_free_products')->nullable();
            $table->decimal('min_total_price', 10,2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_discounts');
    }
};
