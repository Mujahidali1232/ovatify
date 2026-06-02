<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collab_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('song_generation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');                // e.g., "Lorem ipsum"
            $table->string('role')->default('artist'); // requested role: artist | producer | writer | vocals | mixer
            $table->text('message')->nullable();    // optional pitch
            $table->string('status')->default('pending'); // pending | accepted | declined | withdrawn
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            $table->index(['to_user_id', 'status']);
            $table->index(['from_user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collab_requests');
    }
};
