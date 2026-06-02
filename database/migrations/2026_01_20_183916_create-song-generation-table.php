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
        Schema::create('song_generations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('overview')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('instrumental_type')->nullable();
            $table->string('genre')->nullable();
            $table->string('tempo')->nullable();
            $table->json('metadata')->nullable();
            $table->text('agreements')->nullable();
            $table->string('agreement_type')->nullable();
            $table->string('status')->default('pending');
            $table->string('file_type')->nullable();
            $table->string('file')->nullable();
            $table->string('taskId')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_generations');
    }
};
