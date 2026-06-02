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
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('code'); // 4-6 digits
            $table->enum('type', ['email','phone']); // where it was sent
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->string('meta')->nullable(); // optional JSON string for provider trace
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
