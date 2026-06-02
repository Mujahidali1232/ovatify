<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creator_session_ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_session_id')->constrained()->cascadeOnDelete();
            $table->string('type');               // text | audio | document
            $table->text('content')->nullable();  // text idea body
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamps();
            $table->index(['creator_session_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creator_session_ideas');
    }
};
