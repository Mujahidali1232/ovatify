<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('track_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_generation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // null if external collaborator (just a name)
            $table->string('name');                   // display name shown in Figma rows
            $table->string('avatar')->nullable();
            $table->string('role')->default('artist'); // artist | producer | writer | mixer | other
            $table->decimal('percentage', 5, 2)->default(0); // 50.00, 10.00 etc.
            $table->timestamps();
            $table->index('song_generation_id');
            $table->unique(['song_generation_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('track_collaborators');
    }
};
