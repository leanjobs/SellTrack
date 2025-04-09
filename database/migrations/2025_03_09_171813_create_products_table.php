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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique()->nullable();
            $table->string('product_name');
            $table->string('product_img');
            // $table->string('barcode_img');
            $table->decimal('price', 10,2);
            // $table->integer('stock',0)->nullable();
            $table->foreignId('categories_id')->constrained('categories', 'id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
