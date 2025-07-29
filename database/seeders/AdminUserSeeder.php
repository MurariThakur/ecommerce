<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create regular user
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create inactive user
        User::updateOrCreate(
            ['email' => 'inactive@example.com'],
            [
                'name' => 'Inactive User',
                'email' => 'inactive@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => false,
                'email_verified_at' => now(),
            ]
        );

        // Create locked user
        User::updateOrCreate(
            ['email' => 'locked@example.com'],
            [
                'name' => 'Locked User',
                'email' => 'locked@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'locked_until' => now()->addMinutes(30),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin and test users created successfully!');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('User: user@example.com / password');
        $this->command->info('Inactive: inactive@example.com / password (account inactive)');
        $this->command->info('Locked: locked@example.com / password (account locked for 30 minutes)');
    }
}
