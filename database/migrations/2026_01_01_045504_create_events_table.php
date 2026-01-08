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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained()->onDelete('cascade');
            $table->foreignId('gift_id')->nullable()->constrained()->nullOnDelete(); // Gift is optional initially

            $table->string('title'); // "Mom's Birthday"
            $table->date('event_date');
            $table->enum('type', ['birthday', 'anniversary', 'custom']);
            $table->integer('notification_days')->default(7); // Lead time
            $table->enum('status', ['pending', 'scheduled', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
