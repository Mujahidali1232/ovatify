<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CMS-style key/value store for editable website content.
 *
 * Each row is one editable field on the public site (a heading, a paragraph,
 * a phone number, an image). The admin Site Content page lists every row
 * grouped by `group_name` and renders the right input control per `type`.
 *
 * Blade reads values via `\App\Models\SiteSetting::get('key', $default)`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();         // e.g. "hero.heading"
            $table->text('value')->nullable();       // text body, or storage path for images
            $table->string('type', 32)->default('text'); // text|textarea|html|email|url|color|image
            $table->string('group_name', 64);        // Branding | Hero | About | Contact | Social | Footer
            $table->string('label');                 // human label shown in admin
            $table->text('help_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['group_name', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
