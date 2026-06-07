<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;

$rows = [
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
];

// Delete old about settings
SiteSetting::whereIn('key', ['about.title', 'about.body', 'about.image'])->delete();

foreach ($rows as $r) {
    SiteSetting::updateOrCreate(['key' => $r['key']], $r);
}

SiteSetting::flush();
echo "Settings injected successfully.\n";
