<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@ovatify.com'],
            [
                'username' => 'ovatify_admin',
                'phone' => '+10000000000',
                'password' => Hash::make('Admin@2026'),
                'role' => 'admin',
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user ready:');
        $this->command->info('  email:    ' . $admin->email);
        $this->command->info('  password: Admin@2026');
        $this->command->info('  login URL: /admin/login');
    }
}
