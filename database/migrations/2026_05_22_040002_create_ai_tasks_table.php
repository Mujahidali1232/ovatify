<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tool');                // vocal-enhancer | melody-generator | hook-generator | genre-matcher | mood-analyzer | mixing-assistant | lyric-generator | mastering | album-cover
            $table->string('status')->default('pending'); // pending | processing | completed | failed
            $table->json('input')->nullable();     // submitted form fields
            $table->json('result')->nullable();    // structured output
            $table->string('source_audio')->nullable(); // input file storage path
            $table->string('output_file')->nullable();  // result file storage path (audio/image)
            $table->text('error_message')->nullable();
            $table->foreignId('creator_session_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'tool', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_tasks');
    }
};
