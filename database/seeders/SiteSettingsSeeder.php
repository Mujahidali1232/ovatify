<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $year = date('Y');

        $rows = [
            // Branding
            ['key' => 'branding.site_name',     'value' => 'Ovatify',                                'type' => 'text',     'group_name' => 'Branding', 'label' => 'Site Name (browser tab + meta)', 'sort_order' => 1],
            ['key' => 'branding.logo_text',     'value' => 'Ovatify',                                'type' => 'text',     'group_name' => 'Branding', 'label' => 'Navbar Wordmark',                  'sort_order' => 2],
            ['key' => 'branding.primary_color', 'value' => '#FF00FF',                                'type' => 'color',    'group_name' => 'Branding', 'label' => 'Primary Accent Color',             'sort_order' => 3],
            ['key' => 'branding.logo_image',    'value' => '',                                       'type' => 'image',    'group_name' => 'Branding', 'label' => 'Logo Image (optional, replaces wordmark)', 'sort_order' => 4],

            // Hero
            ['key' => 'hero.slides.enabled', 'value' => '1', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Enable Multi-Slide Hero (1/0)', 'sort_order' => 0],

            ['key' => 'hero.slide1.image', 'value' => 'theme/images/slide01.jpg', 'type' => 'image', 'group_name' => 'Hero', 'label' => 'Slide 1 Image', 'sort_order' => 1],
            ['key' => 'hero.slide1.heading', 'value' => 'Music. Ownership. Reinvented.', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Slide 1 Heading', 'sort_order' => 2],
            ['key' => 'hero.slide1.subheading', 'value' => 'A new platform for creators and listeners alike. Sell, license, and invest in music.', 'type' => 'textarea', 'group_name' => 'Hero', 'label' => 'Slide 1 Subheading', 'sort_order' => 3],
            ['key' => 'hero.slide1.cta_text', 'value' => 'Get Started', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Slide 1 CTA Text', 'sort_order' => 4],
            ['key' => 'hero.slide1.cta_url', 'value' => '/register', 'type' => 'url', 'group_name' => 'Hero', 'label' => 'Slide 1 CTA URL', 'sort_order' => 5],

            ['key' => 'hero.slide2.image', 'value' => 'theme/images/slide02.jpg', 'type' => 'image', 'group_name' => 'Hero', 'label' => 'Slide 2 Image', 'sort_order' => 10],
            ['key' => 'hero.slide2.heading', 'value' => 'License, Buy, Invest', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Slide 2 Heading', 'sort_order' => 11],
            ['key' => 'hero.slide2.subheading', 'value' => 'Turn your favorite tracks into real opportunities. Explore licensing, purchases, and investments.', 'type' => 'textarea', 'group_name' => 'Hero', 'label' => 'Slide 2 Subheading', 'sort_order' => 12],
            ['key' => 'hero.slide2.cta_text', 'value' => 'Explore Marketplace', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Slide 2 CTA Text', 'sort_order' => 13],
            ['key' => 'hero.slide2.cta_url', 'value' => '/music', 'type' => 'url', 'group_name' => 'Hero', 'label' => 'Slide 2 CTA URL', 'sort_order' => 14],

            ['key' => 'hero.slide3.image', 'value' => 'theme/images/slide03.jpg', 'type' => 'image', 'group_name' => 'Hero', 'label' => 'Slide 3 Image', 'sort_order' => 20],
            ['key' => 'hero.slide3.heading', 'value' => 'For Creators', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Slide 3 Heading', 'sort_order' => 21],
            ['key' => 'hero.slide3.subheading', 'value' => 'Upload your tracks, set licensing terms, and grow your audience with Ovatify.', 'type' => 'textarea', 'group_name' => 'Hero', 'label' => 'Slide 3 Subheading', 'sort_order' => 22],
            ['key' => 'hero.slide3.cta_text', 'value' => 'Join as Creator', 'type' => 'text', 'group_name' => 'Hero', 'label' => 'Slide 3 CTA Text', 'sort_order' => 23],
            ['key' => 'hero.slide3.cta_url', 'value' => '/register', 'type' => 'url', 'group_name' => 'Hero', 'label' => 'Slide 3 CTA URL', 'sort_order' => 24],

            // About (Search & Creator Layout)
            ['key' => 'home.search.enabled', 'value' => '1', 'type' => 'text', 'group_name' => 'About', 'label' => 'Enable Search Section (1/0)', 'sort_order' => 1],
            ['key' => 'home.search.title', 'value' => 'FEATURED OUR BEAUTIFUL WORKS', 'type' => 'text', 'group_name' => 'About', 'label' => 'Search Section Title', 'sort_order' => 2],
            ['key' => 'home.search.categories', 'value' => 'ALL, MUSIC, IMAGES, MERCHANDISE', 'type' => 'text', 'group_name' => 'About', 'label' => 'Search Categories (comma separated)', 'sort_order' => 3],
            ['key' => 'about.creator.enabled', 'value' => '1', 'type' => 'text', 'group_name' => 'About', 'label' => 'Enable About Creator Section (1/0)', 'sort_order' => 4],
            ['key' => 'about.creator.section_title', 'value' => 'ABOUT CREATOR', 'type' => 'text', 'group_name' => 'About', 'label' => 'About Creator Section Title', 'sort_order' => 5],
            ['key' => 'about.creator.content', 'value' => 'Ovatify connects creators with their audience through licensing, investments, and distribution. We empower artists to share their work securely and seamlessly.', 'type' => 'textarea', 'group_name' => 'About', 'label' => 'Main Text Content', 'sort_order' => 6],
            ['key' => 'about.creator.image_left', 'value' => '', 'type' => 'image', 'group_name' => 'About', 'label' => 'Left Image (Mask/Art)', 'sort_order' => 7],
            ['key' => 'about.creator.profile_image', 'value' => '', 'type' => 'image', 'group_name' => 'About', 'label' => 'Creator Profile Image', 'sort_order' => 8],
            ['key' => 'about.creator.name', 'value' => 'Jenn Roberts', 'type' => 'text', 'group_name' => 'About', 'label' => 'Creator Name', 'sort_order' => 9],
            ['key' => 'about.creator.subtitle', 'value' => 'Love is in the air', 'type' => 'text', 'group_name' => 'About', 'label' => 'Creator Subtitle/Tagline', 'sort_order' => 10],
            ['key' => 'about.creator.description', 'value' => 'Here will be the product detail. For example - if you are a creator you can do everything in one place. Buy to download, License to use, Invest to share revenue.', 'type' => 'textarea', 'group_name' => 'About', 'label' => 'Creator Description', 'sort_order' => 11],
            ['key' => 'about.creator.button_text', 'value' => 'Buy to download', 'type' => 'text', 'group_name' => 'About', 'label' => 'Creator Button Text', 'sort_order' => 12],
            ['key' => 'about.creator.button_url', 'value' => '/register', 'type' => 'url', 'group_name' => 'About', 'label' => 'Creator Button URL', 'sort_order' => 13],

            // Home (Theme sections)
            ['key' => 'home.sections.portfolio_enabled', 'value' => '1', 'type' => 'text', 'group_name' => 'Home', 'label' => 'Show Portfolio / Marketplace Grid (1/0)', 'sort_order' => 1],
            ['key' => 'home.portfolio.kicker',          'value' => 'Portfolio',          'type' => 'text', 'group_name' => 'Home', 'label' => 'Portfolio Kicker (small heading)', 'sort_order' => 2],
            ['key' => 'home.portfolio.title',           'value' => 'Our beautiful works','type' => 'text', 'group_name' => 'Home', 'label' => 'Portfolio Title', 'sort_order' => 3],
            ['key' => 'home.portfolio.load_more_text',  'value' => 'Explore more',       'type' => 'text', 'group_name' => 'Home', 'label' => 'Portfolio Load More Text', 'sort_order' => 4],
            ['key' => 'home.portfolio.load_more_url',   'value' => '/images',            'type' => 'url',  'group_name' => 'Home', 'label' => 'Portfolio Load More URL', 'sort_order' => 5],
            ['key' => 'home.portfolio.placeholder_image', 'value' => 'theme/images/models_square/01.jpg','type' => 'image','group_name' => 'Home', 'label' => 'Portfolio Load More Background Image', 'sort_order' => 6],

            ['key' => 'home.portfolio.cms1.image', 'value' => 'theme/images/models_square/14.jpg', 'type' => 'image', 'group_name' => 'Home', 'label' => 'Portfolio Item #1 Image', 'sort_order' => 60],
            ['key' => 'home.portfolio.cms1.title', 'value' => 'Sunset Portrait',                 'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #1 Title', 'sort_order' => 61],
            ['key' => 'home.portfolio.cms1.by',    'value' => 'Luna Beats',                      'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #1 By', 'sort_order' => 62],
            ['key' => 'home.portfolio.cms1.genre', 'value' => 'POP',                             'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #1 Genre', 'sort_order' => 63],
            ['key' => 'home.portfolio.cms1.url',   'value' => '/images',                         'type' => 'url',   'group_name' => 'Home', 'label' => 'Portfolio Item #1 URL', 'sort_order' => 64],

            ['key' => 'home.portfolio.cms2.image', 'value' => 'theme/images/models_square/21.jpg', 'type' => 'image', 'group_name' => 'Home', 'label' => 'Portfolio Item #2 Image', 'sort_order' => 70],
            ['key' => 'home.portfolio.cms2.title', 'value' => 'Neon City',                         'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #2 Title', 'sort_order' => 71],
            ['key' => 'home.portfolio.cms2.by',    'value' => 'Luna Beats',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #2 By', 'sort_order' => 72],
            ['key' => 'home.portfolio.cms2.genre', 'value' => 'EDM',                               'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #2 Genre', 'sort_order' => 73],
            ['key' => 'home.portfolio.cms2.url',   'value' => '/images',                           'type' => 'url',   'group_name' => 'Home', 'label' => 'Portfolio Item #2 URL', 'sort_order' => 74],

            ['key' => 'home.portfolio.cms3.image', 'value' => 'theme/images/models_square/03.jpg', 'type' => 'image', 'group_name' => 'Home', 'label' => 'Portfolio Item #3 Image', 'sort_order' => 80],
            ['key' => 'home.portfolio.cms3.title', 'value' => 'Abstract Waves',                    'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #3 Title', 'sort_order' => 81],
            ['key' => 'home.portfolio.cms3.by',    'value' => 'Luna Beats',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #3 By', 'sort_order' => 82],
            ['key' => 'home.portfolio.cms3.genre', 'value' => 'Lo-fi',                             'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #3 Genre', 'sort_order' => 83],
            ['key' => 'home.portfolio.cms3.url',   'value' => '/images',                           'type' => 'url',   'group_name' => 'Home', 'label' => 'Portfolio Item #3 URL', 'sort_order' => 84],

            ['key' => 'home.portfolio.cms4.image', 'value' => 'theme/images/models_square/22.jpg', 'type' => 'image', 'group_name' => 'Home', 'label' => 'Portfolio Item #4 Image', 'sort_order' => 90],
            ['key' => 'home.portfolio.cms4.title', 'value' => 'Cover Art: Electric Pulse',         'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #4 Title', 'sort_order' => 91],
            ['key' => 'home.portfolio.cms4.by',    'value' => 'Nova Sound',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #4 By', 'sort_order' => 92],
            ['key' => 'home.portfolio.cms4.genre', 'value' => 'EDM',                               'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #4 Genre', 'sort_order' => 93],
            ['key' => 'home.portfolio.cms4.url',   'value' => '/images',                           'type' => 'url',   'group_name' => 'Home', 'label' => 'Portfolio Item #4 URL', 'sort_order' => 94],

            ['key' => 'home.portfolio.cms5.image', 'value' => 'theme/images/models_square/14.jpg', 'type' => 'image', 'group_name' => 'Home', 'label' => 'Portfolio Item #5 Image', 'sort_order' => 100],
            ['key' => 'home.portfolio.cms5.title', 'value' => 'Dreamscape',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #5 Title', 'sort_order' => 101],
            ['key' => 'home.portfolio.cms5.by',    'value' => 'Luna Beats',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #5 By', 'sort_order' => 102],
            ['key' => 'home.portfolio.cms5.genre', 'value' => 'Ambient',                           'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #5 Genre', 'sort_order' => 103],
            ['key' => 'home.portfolio.cms5.url',   'value' => '/images',                           'type' => 'url',   'group_name' => 'Home', 'label' => 'Portfolio Item #5 URL', 'sort_order' => 104],

            ['key' => 'home.portfolio.cms6.image', 'value' => 'theme/images/models_square/21.jpg', 'type' => 'image', 'group_name' => 'Home', 'label' => 'Portfolio Item #6 Image', 'sort_order' => 110],
            ['key' => 'home.portfolio.cms6.title', 'value' => 'Vibe Check',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #6 Title', 'sort_order' => 111],
            ['key' => 'home.portfolio.cms6.by',    'value' => 'Nova Sound',                        'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #6 By', 'sort_order' => 112],
            ['key' => 'home.portfolio.cms6.genre', 'value' => 'Hip Hop',                           'type' => 'text',  'group_name' => 'Home', 'label' => 'Portfolio Item #6 Genre', 'sort_order' => 113],
            ['key' => 'home.portfolio.cms6.url',   'value' => '/images',                           'type' => 'url',   'group_name' => 'Home', 'label' => 'Portfolio Item #6 URL', 'sort_order' => 114],

            ['key' => 'home.sections.songs_enabled',     'value' => '1',                  'type' => 'text', 'group_name' => 'Home', 'label' => 'Show Songs Covers Grid (1/0)', 'sort_order' => 6],
            ['key' => 'home.songs.kicker',               'value' => 'Music',              'type' => 'text', 'group_name' => 'Home', 'label' => 'Songs Kicker', 'sort_order' => 7],
            ['key' => 'home.songs.title',                'value' => 'Trending songs',     'type' => 'text', 'group_name' => 'Home', 'label' => 'Songs Title', 'sort_order' => 8],
            ['key' => 'home.songs.more_text',            'value' => 'Explore songs',      'type' => 'text', 'group_name' => 'Home', 'label' => 'Songs More Text', 'sort_order' => 9],
            ['key' => 'home.songs.more_url',             'value' => '/music',             'type' => 'url',  'group_name' => 'Home', 'label' => 'Songs More URL', 'sort_order' => 9],
            ['key' => 'home.songs.placeholder_image',     'value' => 'theme/images/models_square/01.jpg','type' => 'image','group_name' => 'Home', 'label' => 'Songs Placeholder Image (optional)', 'sort_order' => 9],

            ['key' => 'home.sections.creators_enabled', 'value' => '1', 'type' => 'text', 'group_name' => 'Home', 'label' => 'Show Creators Carousel (1/0)', 'sort_order' => 10],
            ['key' => 'home.creators.kicker',           'value' => 'Creators',           'type' => 'text', 'group_name' => 'Home', 'label' => 'Creators Kicker', 'sort_order' => 11],
            ['key' => 'home.creators.title',            'value' => 'Featured creators',  'type' => 'text', 'group_name' => 'Home', 'label' => 'Creators Title', 'sort_order' => 12],
            ['key' => 'home.creators.placeholder_avatar', 'value' => 'theme/images/models_portrait/01.jpg','type' => 'image','group_name' => 'Home', 'label' => 'Creators Placeholder Avatar (optional)', 'sort_order' => 13],

            ['key' => 'home.sections.casting_enabled',  'value' => '1', 'type' => 'text', 'group_name' => 'Home', 'label' => 'Show Casting/CTA Section (1/0)', 'sort_order' => 20],
            ['key' => 'home.casting.kicker',            'value' => 'Casting',            'type' => 'text', 'group_name' => 'Home', 'label' => 'Casting Kicker', 'sort_order' => 21],
            ['key' => 'home.casting.title',             'value' => 'Do you want be a',   'type' => 'text', 'group_name' => 'Home', 'label' => 'Casting Title', 'sort_order' => 22],
            ['key' => 'home.casting.subtitle',          'value' => 'Creator',            'type' => 'text', 'group_name' => 'Home', 'label' => 'Casting Subtitle', 'sort_order' => 23],
            ['key' => 'home.casting.body',              'value' => 'Join Ovatify as a creator and start selling, licensing, and raising investments for your work.', 'type' => 'textarea', 'group_name' => 'Home', 'label' => 'Casting Body', 'sort_order' => 24],
            ['key' => 'home.casting.cta_text',          'value' => 'Discover more',      'type' => 'text', 'group_name' => 'Home', 'label' => 'Casting CTA Text', 'sort_order' => 25],
            ['key' => 'home.casting.cta_url',           'value' => '/register',          'type' => 'url',  'group_name' => 'Home', 'label' => 'Casting CTA URL', 'sort_order' => 26],
            ['key' => 'home.casting.image',             'value' => '',                   'type' => 'image','group_name' => 'Home', 'label' => 'Casting Image', 'sort_order' => 27],

            ['key' => 'home.sections.blog_enabled',     'value' => '0', 'type' => 'text', 'group_name' => 'Home', 'label' => 'Show Blog Section (1/0)', 'sort_order' => 30],
            ['key' => 'home.blog.kicker',               'value' => 'Blog',               'type' => 'text', 'group_name' => 'Home', 'label' => 'Blog Kicker', 'sort_order' => 31],
            ['key' => 'home.blog.title',                'value' => 'Last News',          'type' => 'text', 'group_name' => 'Home', 'label' => 'Blog Title', 'sort_order' => 32],
            ['key' => 'home.blog.more_text',            'value' => 'Discover more posts','type' => 'text', 'group_name' => 'Home', 'label' => 'Blog More Text', 'sort_order' => 33],
            ['key' => 'home.blog.more_url',             'value' => '/blog',              'type' => 'url',  'group_name' => 'Home', 'label' => 'Blog More URL', 'sort_order' => 34],

            ['key' => 'home.sections.banner_enabled',   'value' => '1', 'type' => 'text', 'group_name' => 'Home', 'label' => 'Show Banner/Apply Section (1/0)', 'sort_order' => 40],
            ['key' => 'home.banner.line1',              'value' => 'Discover trending songs from creators worldwide', 'type' => 'text',     'group_name' => 'Home', 'label' => 'Banner Line 1', 'sort_order' => 41],
            ['key' => 'home.banner.line2',              'value' => 'License, buy, or invest in tracks you love',      'type' => 'text',     'group_name' => 'Home', 'label' => 'Banner Line 2', 'sort_order' => 42],
            ['key' => 'home.banner.cta_text',           'value' => 'Explore Songs',                                    'type' => 'text',     'group_name' => 'Home', 'label' => 'Banner CTA Text', 'sort_order' => 43],
            ['key' => 'home.banner.cta_url',            'value' => '/music',                                           'type' => 'url',      'group_name' => 'Home', 'label' => 'Banner CTA URL', 'sort_order' => 44],

            // Contact
            ['key' => 'contact.address', 'value' => '123 Music St, Los Angeles, CA',  'type' => 'textarea', 'group_name' => 'Contact', 'label' => 'Address',  'sort_order' => 1],
            ['key' => 'contact.phone',   'value' => '+1 (555) 123-4567',              'type' => 'text',     'group_name' => 'Contact', 'label' => 'Phone',    'sort_order' => 2],
            ['key' => 'contact.email',   'value' => 'support@ovatify.com',            'type' => 'email',    'group_name' => 'Contact', 'label' => 'Email',    'sort_order' => 3],

            // Social
            ['key' => 'social.facebook',  'value' => 'https://facebook.com/',  'type' => 'url', 'group_name' => 'Social', 'label' => 'Facebook URL',  'sort_order' => 1],
            ['key' => 'social.twitter',   'value' => 'https://x.com/',         'type' => 'url', 'group_name' => 'Social', 'label' => 'X / Twitter URL', 'sort_order' => 2],
            ['key' => 'social.instagram', 'value' => 'https://instagram.com/', 'type' => 'url', 'group_name' => 'Social', 'label' => 'Instagram URL', 'sort_order' => 3],
            ['key' => 'social.youtube',   'value' => 'https://youtube.com/',   'type' => 'url', 'group_name' => 'Social', 'label' => 'YouTube URL',   'sort_order' => 4],

            // Footer
            ['key' => 'footer.copyright', 'value' => "© {$year} Ovatify. All rights reserved.", 'type' => 'text',     'group_name' => 'Footer', 'label' => 'Copyright Line',  'sort_order' => 1],
            ['key' => 'footer.tagline',   'value' => 'Built for creators. Owned by you.',       'type' => 'text',     'group_name' => 'Footer', 'label' => 'Footer Tagline',  'sort_order' => 2],
        ];

        foreach ($rows as $r) {
            SiteSetting::updateOrCreate(['key' => $r['key']], $r);
        }

        SiteSetting::flush();
    }
}
