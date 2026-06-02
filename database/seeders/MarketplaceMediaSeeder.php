<?php

namespace Database\Seeders;

use App\Models\MarketplaceAsset;
use App\Models\SongGeneration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Seeds sample image / video media so the Marketplace "Images/Illustrations"
 * tabs (and the matching ?type filters on featured/trending/recommended/
 * recently-added endpoints) return data instead of empty arrays.
 *
 * Safe to re-run — uses updateOrCreate keyed on title.
 */
class MarketplaceMediaSeeder extends Seeder
{
    public function run(): void
    {
        $baseUrl = rtrim(config('app.url') ?: 'http://127.0.0.1:8000', '/');
        $assetUrl = function (string $path) use ($baseUrl): string {
            // If already absolute, keep it.
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }
            return $baseUrl.'/'.ltrim($path, '/');
        };

        // Prefer storing local theme assets as relative paths so they work even if APP_URL differs.
        $themePath = function (string $path): string {
            return ltrim($path, '/');
        };

        // Make sure we have creators to own the media (safe to re-run).
        $creator = User::firstOrNew(['email' => 'luna_beats@example.com']);
        if (! $creator->exists) {
            $creator->password = Hash::make('xxx');
            $creator->email_verified_at = now();
        }
        $creator->fill([
            'username' => 'Luna Beats',
            'phone' => '+19998887777',
            'role' => 'creator',
            'is_active' => true,
            'is_verified' => true,
            'bio' => 'Pop music expert',
            'profile_image' => $themePath('theme/images/models_portrait/09.jpg'),
        ]);
        $creator->save();

        // A second creator for variety.
        $creator2 = User::firstOrNew(['email' => 'nova_sound@example.com']);
        if (! $creator2->exists) {
            $creator2->password = Hash::make('xxx');
            $creator2->email_verified_at = now();
        }
        $creator2->fill([
            'username' => 'Nova Sound',
            'phone' => '+19997776666',
            'role' => 'creator',
            'is_active' => true,
            'is_verified' => true,
            'bio' => 'Cinematic hip-hop producer',
            'profile_image' => $themePath('theme/images/models_portrait/15.jpg'),
        ]);
        $creator2->save();

        $samples = [
            // ------------ AUDIO SONGS ------------
            [
                'owner_email' => 'luna_beats@example.com',
                'title' => 'Midnight Drive',
                'overview' => 'Synthwave groove for night rides',
                'description' => 'A clean synthwave beat with driving bass and airy pads.',
                'file_type' => 'audio',
                'cover_image' => $themePath('theme/images/models_square/22.jpg'),
                'file' => $themePath('theme/images/audio.mp3'),
                'genre' => 'Synthwave',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'audio',
                'sale_type' => 'sale',
                'price' => 29.00,
                'width_px' => 1600, 'height_px' => 1600,
                'orientation' => 'square', 'file_format' => 'MP3',
                'file_size_bytes' => 8 * 1024 * 1024,
                'tags' => ['synthwave', 'night', 'drive'],
            ],
            [
                'owner_email' => 'nova_sound@example.com',
                'title' => 'City Lights',
                'overview' => 'Cinematic hip-hop instrumental',
                'description' => 'Moody drums + cinematic textures. Perfect for trailers or promos.',
                'file_type' => 'audio',
                'cover_image' => $themePath('theme/images/models_square/24.jpg'),
                'file' => $themePath('theme/images/audio.mp3'),
                'genre' => 'Hip-Hop',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'audio',
                'sale_type' => 'license',
                'price' => 0,
                'price_per_license' => 59.00,
                'license_type' => 'commercial',
                'license_duration' => 12,
                'width_px' => 1600, 'height_px' => 1600,
                'orientation' => 'square', 'file_format' => 'MP3',
                'file_size_bytes' => 9 * 1024 * 1024,
                'tags' => ['cinematic', 'hiphop', 'license'],
            ],
            [
                'owner_email' => 'luna_beats@example.com',
                'title' => 'Ocean Breeze',
                'overview' => 'Chill pop instrumental',
                'description' => 'Lightweight pop instrumental with bright chords and soft drums.',
                'file_type' => 'audio',
                // Use local theme cover to avoid external image blocking.
                'cover_image' => $themePath('theme/images/models_square/25.jpg'),
                'file' => $themePath('theme/images/audio.mp3'),
                'genre' => 'Pop',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'audio',
                'sale_type' => 'sale',
                'price' => 25.00,
                'width_px' => 1600, 'height_px' => 1600,
                'orientation' => 'square', 'file_format' => 'MP3',
                'file_size_bytes' => 8 * 1024 * 1024,
                'tags' => ['chill', 'pop', 'instrumental'],
            ],

            // ------------ ILLUSTRATIONS ------------
            [
                'title' => 'Abstract Waves',
                'overview' => '1600x1600 abstract illustration',
                'description' => 'Modern abstract waves in neon palette.',
                'file_type' => 'illustration',
                'cover_image' => $themePath('theme/images/models_square/03.jpg'),
                'file' => $themePath('theme/images/models_square/03.jpg'),
                'genre' => 'Lo-fi',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'illustration',
                'sale_type' => 'sale',
                'price' => 19.00,
                'width_px' => 1600, 'height_px' => 1600,
                'orientation' => 'square', 'file_format' => 'PNG',
                'file_size_bytes' => 10 * 1024 * 1024, // 10 MB
                'tags' => ['abstract', 'waves', 'neon'],
            ],
            [
                'title' => 'Neon City',
                'overview' => '1920x1080 cyberpunk cityscape',
                'description' => 'Cyberpunk-style city scene with neon.',
                'file_type' => 'illustration',
                'cover_image' => $themePath('theme/images/models_square/21.jpg'),
                'file' => $themePath('theme/images/models_square/21.jpg'),
                'genre' => 'EDM',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'illustration',
                'sale_type' => 'sale',
                'price' => 24.00,
                'width_px' => 1920, 'height_px' => 1080,
                'orientation' => 'landscape', 'file_format' => 'JPG',
                'file_size_bytes' => 4 * 1024 * 1024,
                'tags' => ['cyberpunk', 'city', 'night'],
            ],
            [
                'title' => 'Sunset Portrait',
                'overview' => '1080x1920 portrait illustration',
                'description' => 'Warm sunset gradient portrait.',
                'file_type' => 'illustration',
                'cover_image' => $themePath('theme/images/models_square/14.jpg'),
                'file' => $themePath('theme/images/models_square/14.jpg'),
                'genre' => 'POP',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'illustration',
                'sale_type' => 'license',
                'price' => 0,
                'price_per_license' => 49.00,
                'license_type' => 'personal',
                'license_duration' => 12,
                'width_px' => 1080, 'height_px' => 1920,
                'orientation' => 'portrait', 'file_format' => 'PNG',
                'file_size_bytes' => 6 * 1024 * 1024,
                'tags' => ['portrait', 'sunset', 'warm'],
            ],
            [
                'owner_email' => 'nova_sound@example.com',
                'title' => 'Cover Art: Electric Pulse',
                'overview' => 'Online cover art sample (1600x1600)',
                'description' => 'Demo online image for cover art and marketplace thumbnails.',
                'file_type' => 'illustration',
                'cover_image' => 'https://picsum.photos/seed/ovatify_cover_pulse/1600/1600',
                'file' => 'https://picsum.photos/seed/ovatify_cover_pulse/1600/1600',
                'genre' => 'EDM',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'illustration',
                'sale_type' => 'sale',
                'price' => 29.00,
                'width_px' => 1600, 'height_px' => 1600,
                'orientation' => 'square', 'file_format' => 'JPG',
                'file_size_bytes' => 2 * 1024 * 1024,
                'tags' => ['cover', 'art', 'online'],
            ],

            // ------------ VIDEOS ------------
            [
                'title' => 'Wave Loop',
                'overview' => '4-second loop, 1920x1080 mp4',
                'description' => 'Seamless abstract wave loop for backgrounds.',
                'file_type' => 'video',
                'cover_image' => $themePath('theme/images/slide02.jpg'),
                'file' => $themePath('theme/images/slide02.jpg'),
                'genre' => 'Lo-fi',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'video',
                'sale_type' => 'sale',
                'price' => 39.00,
                'width_px' => 1920, 'height_px' => 1080,
                'orientation' => 'landscape', 'file_format' => 'MP4',
                'file_size_bytes' => 18 * 1024 * 1024,
                'tags' => ['loop', 'background', 'abstract'],
            ],
            [
                'title' => 'City Drive',
                'overview' => '10s driving footage 4K',
                'description' => 'Cinematic night drive through neon city.',
                'file_type' => 'video',
                'cover_image' => $themePath('theme/images/slide03.jpg'),
                'file' => $themePath('theme/images/slide03.jpg'),
                'genre' => 'Hip-Hop',
                'agreements' => 'Standard Artist Agreement.',
                'asset_type' => 'video',
                'sale_type' => 'sale',
                'price' => 79.00,
                'width_px' => 3840, 'height_px' => 2160,
                'orientation' => 'landscape', 'file_format' => 'MP4',
                'file_size_bytes' => 96 * 1024 * 1024,
                'tags' => ['cinematic', 'city', '4k'],
            ],
        ];

        foreach ($samples as $s) {
            $owner = $creator;
            if (!empty($s['owner_email'])) {
                $owner = ($s['owner_email'] === $creator2->email) ? $creator2 : $creator;
            }

            $song = SongGeneration::updateOrCreate(
                ['title' => $s['title'], 'user_id' => $owner->id],
                [
                    'overview' => $s['overview'],
                    'description' => $s['description'],
                    'cover_image' => $s['cover_image'],
                    'file' => $s['file'],
                    'file_type' => $s['file_type'],
                    'genre' => $s['genre'],
                    'agreements' => $s['agreements'],
                    'status' => 'uploaded',
                ]
            );

            MarketplaceAsset::updateOrCreate(
                ['song_generation_id' => $song->id, 'sale_type' => $s['sale_type']],
                [
                    'user_id' => $owner->id,
                    'asset_type' => $s['asset_type'],
                    'title' => $s['title'],
                    'thumbnail' => $s['cover_image'],
                    'tags' => $s['tags'],
                    'description' => $s['description'],
                    'price' => $s['price'],
                    'price_per_license' => $s['price_per_license'] ?? null,
                    'license_type' => $s['license_type'] ?? null,
                    'license_duration' => $s['license_duration'] ?? null,
                    'width_px' => $s['width_px'],
                    'height_px' => $s['height_px'],
                    'orientation' => $s['orientation'],
                    'file_format' => $s['file_format'],
                    'file_size_bytes' => $s['file_size_bytes'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info(sprintf(
            'Seeded %d sample media items (illustrations + videos) under creator %s.',
            count($samples), $creator->email
        ));
    }
}
