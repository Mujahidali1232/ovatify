<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marketplace_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('song_generation_id');
            $table->enum('asset_type', ['video', 'audio', 'illustration']);

            // File info
            // $table->string('file_path')->nullable();
            // $table->string('file_type')->nullable(); // mp4, mp3, png etc
            $table->string(column: 'title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('tags')->nullable();
            $table->text('description')->nullable();

            // Sale models
            $table->enum('sale_type', ['sale', 'investment', 'license']);
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('preview_duration')->nullable();

            // License & investment
            $table->string('license_type')->nullable();
            $table->decimal('price_per_license', 10, 2)->nullable();
            $table->integer('license_duration')->nullable();
            

            $table->integer('total_valuation')->nullable();
            $table->integer('ownership_block')->nullable();
            $table->integer('price_per_block')->nullable();
            $table->integer('max_available_blocks')->nullable();
            $table->integer('remaining_blocks')->nullable();
            $table->decimal('total_investment', 10, 2)->nullable();
            $table->decimal('max_earning', 10, 2)->nullable();
            $table->decimal('investment_roi', 5, 2)->nullable(); 

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('song_generation_id')->references('id')->on('song_generations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_assets');
    }
};
