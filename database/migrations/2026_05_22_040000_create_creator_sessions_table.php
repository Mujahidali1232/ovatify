<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creator_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('overview')->nullable();
            $table->string('cover_image')->nullable();        // storage path
            $table->string('file_type')->default('audio');    // audio | video | illustration

            // Customization
            $table->string('instrumental_type')->nullable(); // Solo singer / Duet / Group/Band / Backing
            $table->string('genre')->nullable();             // POP / Rock / etc.
            $table->unsignedInteger('tempo')->nullable();    // BPM

            // Pipeline output
            $table->string('generated_audio')->nullable();   // raw AI generation result
            $table->string('final_audio')->nullable();       // post-mix/arrange output
            $table->json('mix_settings')->nullable();        // { tempo, equalizer: {64Hz, 800Hz, ...} }
            $table->json('arrangement')->nullable();         // { tempo: [...], beat: [...], vocals: [...], bass: [...] }
            $table->json('metadata_review')->nullable();     // { genre, bpm, ... } from completed-summary screen

            // Pipeline state
            $table->string('status')->default('draft');      // draft | ideas | customizing | generating | mixing | arranging | completed | published
            $table->foreignId('published_song_generation_id')->nullable()->constrained('song_generations')->nullOnDelete();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creator_sessions');
    }
};
