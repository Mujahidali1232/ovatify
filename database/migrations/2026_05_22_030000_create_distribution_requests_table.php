<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribution_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('song_generation_id')->constrained('song_generations')->cascadeOnDelete();
            $table->string('release_title');
            $table->string('artist_name');
            $table->date('release_date')->nullable();
            $table->string('isrc_code')->nullable();
            $table->string('cover_art')->nullable(); // storage path
            $table->json('platforms');               // ["spotify", "yt-music", "tidal"]
            $table->string('status')->default('pending'); // pending | processing | distributed | failed
            $table->timestamp('distributed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('song_generation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribution_requests');
    }
};
