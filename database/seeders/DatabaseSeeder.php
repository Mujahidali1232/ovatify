<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Global CMS/lookups + demo marketplace content for homepage.
        $this->call([
            SiteSettingsSeeder::class,
            LookupSeeder::class,
            MarketplaceMediaSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'AdminUser',
                'password' => 'password',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@ovatify.com'],
            [
                'username' => 'Admin',
                'role' => 'admin',
                'password' => 'admin123',
            ]
        );

        User::updateOrCreate(
            ['email' => 'consumer@ovatify.com'],
            [
                'username' => 'ConsumerUser',
                'role' => 'consumer',
                'password' => 'password123', // This will automatically be hashed by the User model's setter
            ]
        );

        User::updateOrCreate(
            ['email' => 'creator@ovatify.com'],
            [
                'username' => 'CreatorUser',
                'role' => 'creator',
                'password' => 'password123', // This will automatically be hashed by the User model's setter
            ]
        );
    }
}
