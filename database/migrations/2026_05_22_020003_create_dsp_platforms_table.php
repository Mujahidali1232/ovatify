<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dsp_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name');                // "Spotify"
            $table->string('slug')->unique();      // "spotify"
            $table->string('icon')->nullable();    // icon URL or storage path
            $table->string('brand_color')->nullable(); // "#1DB954"
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dsp_platforms');
    }
};
