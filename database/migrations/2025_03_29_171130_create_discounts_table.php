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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['cheap_redemption', 'percentage_off', 'buy_x_get_y', 'member']);
            $table->string('discount_name');
            $table->foreignId('detail_discounts_id')->constrained('detail_discounts', 'id');
            $table->foreignId('branches_id')->nullable()->constrained('branches', 'id');
            $table->boolean('all_branches')->default(false);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'incative']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
