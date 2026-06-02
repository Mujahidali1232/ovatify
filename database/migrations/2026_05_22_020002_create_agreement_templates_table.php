<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agreement_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // "Standard Artist Agreement"
            $table->string('slug')->unique();        // "standard-artist"
            $table->string('category')->nullable(); // "Artist", "Producer", "Collaboration", "Publishing"
            $table->string('type')->default('legal'); // "Legal Agreement"
            $table->longText('body');                // full agreement markdown / rich text
            $table->boolean('is_system')->default(false); // built-in vs creator-uploaded
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // null for system templates
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreement_templates');
    }
};
