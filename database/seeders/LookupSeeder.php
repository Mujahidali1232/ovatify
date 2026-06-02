<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\LicenseTier;
use App\Models\AgreementTemplate;
use App\Models\DspPlatform;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedGenres();
        $this->seedLicenseTiers();
        $this->seedAgreementTemplates();
        $this->seedDspPlatforms();
    }

    private function seedGenres(): void
    {
        $genres = [
            ['name' => 'POP', 'slug' => 'pop'],
            ['name' => 'Rock', 'slug' => 'rock'],
            ['name' => 'Hip-Hop', 'slug' => 'hip-hop'],
            ['name' => 'R&B', 'slug' => 'rnb'],
            ['name' => 'EDM', 'slug' => 'edm'],
            ['name' => 'Jazz', 'slug' => 'jazz'],
            ['name' => 'Classical', 'slug' => 'classical'],
            ['name' => 'Reggae', 'slug' => 'reggae'],
            ['name' => 'Lo-fi', 'slug' => 'lo-fi'],
            ['name' => 'Country', 'slug' => 'country'],
            ['name' => 'Indie', 'slug' => 'indie'],
            ['name' => 'Folk', 'slug' => 'folk'],
        ];
        foreach ($genres as $i => $g) {
            Genre::updateOrCreate(['slug' => $g['slug']], $g + ['sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedLicenseTiers(): void
    {
        $tiers = [
            [
                'name' => 'Personal license',
                'slug' => 'personal',
                'default_price' => 99.00,
                'description' => 'Personal, non-commercial use.',
                'features' => ['Digital & Print use', 'Up to 5M Impressions', 'Unlimited Projects', 'Royalty Free'],
                'default_duration_months' => 12,
            ],
            [
                'name' => 'Commercial license',
                'slug' => 'commercial',
                'default_price' => 99.00,
                'description' => 'Use in commercial projects.',
                'features' => ['Commercial use', 'Unlimited distribution', 'Royalty Free'],
                'default_duration_months' => 60,
            ],
            [
                'name' => 'YouTube Monetization',
                'slug' => 'youtube-monetization',
                'default_price' => 99.00,
                'description' => 'Use in monetized YouTube content.',
                'features' => ['YouTube content ID safe', 'Unlimited videos', 'Monetization enabled'],
                'default_duration_months' => 96,
            ],
            [
                'name' => 'Sync licensing (for ads, TV, etc.)',
                'slug' => 'sync',
                'default_price' => 99.00,
                'description' => 'Sync in ads, TV, film, broadcast.',
                'features' => ['Sync rights', 'Broadcast clearance', 'Single project'],
                'default_duration_months' => null, // lifetime per project
            ],
        ];
        foreach ($tiers as $i => $t) {
            LicenseTier::updateOrCreate(['slug' => $t['slug']], $t + ['sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedAgreementTemplates(): void
    {
        $body = <<<MD
**1. Grant of Rights**
The Artist grants the Producer/Label the non-exclusive right to record, distribute, and promote the musical works created under this agreement.

**2. Compensation & Royalties**
Royalties shall be split as follows:
- Artist: [Insert %]
- Producer/Label: [Insert %]
Payments will be made quarterly via [Preferred Payment Method].

**3. Ownership & Copyright**
The copyright of the composition and master recording will be shared equally unless otherwise stated in writing.

**4. Creative Control**
Both parties agree to maintain open communication regarding changes, releases, or public performances.

**5. Term & Termination**
This agreement is valid for [Insert Duration], and either party may terminate it with a 30-day written notice.

**6. Signatures**
By signing below, both parties agree to the terms outlined above.

Artist Signature: _________________
Producer/Label Signature: _________________
Date: _________________
MD;

        $templates = [
            [
                'name' => 'Standard Artist Agreement',
                'slug' => 'standard-artist',
                'category' => 'Artist',
                'type' => 'Legal Agreement',
            ],
            [
                'name' => 'Producer Agreement',
                'slug' => 'producer',
                'category' => 'Producer',
                'type' => 'Legal Agreement',
            ],
            [
                'name' => 'Collaboration Contract',
                'slug' => 'collaboration',
                'category' => 'Collaboration',
                'type' => 'Legal Agreement',
            ],
            [
                'name' => 'Publishing Split Sheet',
                'slug' => 'publishing-split',
                'category' => 'Publishing',
                'type' => 'Legal Agreement',
            ],
        ];
        foreach ($templates as $i => $t) {
            AgreementTemplate::updateOrCreate(
                ['slug' => $t['slug']],
                $t + [
                    'body' => $body,
                    'is_system' => true,
                    'is_active' => true,
                    'sort_order' => $i,
                    'user_id' => null,
                ]
            );
        }
    }

    private function seedDspPlatforms(): void
    {
        $platforms = [
            ['name' => 'Spotify',  'slug' => 'spotify',  'brand_color' => '#1DB954'],
            ['name' => 'YT Music', 'slug' => 'yt-music', 'brand_color' => '#FF0000'],
            ['name' => 'Tidal',    'slug' => 'tidal',    'brand_color' => '#000000'],
            ['name' => 'Apple Music', 'slug' => 'apple-music', 'brand_color' => '#FA243C'],
            ['name' => 'Amazon Music', 'slug' => 'amazon-music', 'brand_color' => '#00A8E1'],
            ['name' => 'SoundCloud', 'slug' => 'soundcloud', 'brand_color' => '#FF5500'],
        ];
        foreach ($platforms as $i => $p) {
            DspPlatform::updateOrCreate(['slug' => $p['slug']], $p + ['sort_order' => $i, 'is_active' => true]);
        }
    }
}
