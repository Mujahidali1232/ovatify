<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Backfills two Figma-driven gaps:
 *  1. users.bio — the "Pop music expert" subtitle shown in every artist row.
 *  2. marketplace_assets image metadata — the "Type: Photo, Orientation: Square,
 *     Resolution: 1600x1600, PNG - 10 MB" block on the Image Detail screen.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio', 160)->nullable()->after('profile_image');
        });

        Schema::table('marketplace_assets', function (Blueprint $table) {
            $table->unsignedInteger('width_px')->nullable()->after('asset_type');
            $table->unsignedInteger('height_px')->nullable()->after('width_px');
            $table->string('orientation', 16)->nullable()->after('height_px');   // square|portrait|landscape
            $table->string('file_format', 16)->nullable()->after('orientation'); // PNG | JPG | MP4 | WAV | ...
            $table->unsignedBigInteger('file_size_bytes')->nullable()->after('file_format');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bio');
        });

        Schema::table('marketplace_assets', function (Blueprint $table) {
            $table->dropColumn(['width_px', 'height_px', 'orientation', 'file_format', 'file_size_bytes']);
        });
    }
};
