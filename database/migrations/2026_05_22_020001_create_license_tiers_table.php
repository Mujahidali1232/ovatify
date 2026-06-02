<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('license_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // "Personal license"
            $table->string('slug')->unique();             // "personal"
            $table->decimal('default_price', 10, 2);      // 99.00
            $table->text('description')->nullable();
            $table->json('features')->nullable();         // ["Digital & Print use", "Up to 5M Impressions", ...]
            $table->unsignedInteger('default_duration_months')->nullable(); // 12, 60, 96, null=lifetime
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('license_tiers');
    }
};
