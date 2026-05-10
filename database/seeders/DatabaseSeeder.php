<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // System-wide Administrator (system owner / developer)
        User::updateOrCreate(
            ['email' => 'administrator@komunitech.com'],
            [
                'name' => 'Komunitech Administrator',
                'password' => Hash::make('password'), // change to secure password
                'role' => User::ROLE_ADMINISTRATOR,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Barangay Admin (barangay-level operator)
        User::updateOrCreate(
            ['email' => 'barangayadmin@komunitech.com'],
            [
                'name' => 'Barangay Admin',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Regular User (resident)
        User::updateOrCreate(
            ['email' => 'user@komunitech.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'), // change to secure password
                'role' => User::ROLE_USER,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
