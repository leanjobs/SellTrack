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
        // Schema::create('notifications', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('branches_id')->constrained('branches', 'id');
        //     $table->string('messages');
        //     $table->enum('status', ['read', 'unread']);
        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('notifications');
    }
};
