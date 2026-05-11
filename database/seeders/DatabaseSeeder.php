<?php

namespace Database\Seeders;

use App\Models\Subscription;
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
        $barangayAdmin = User::updateOrCreate(
            ['email' => 'barangayadmin@komunitech.com'],
            [
                'name' => 'Barangay Admin',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_ADMIN,
                'barangay' => User::DEFAULT_BARANGAY,
                'is_seeder' => true,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );

        Subscription::updateOrCreate(
            ['user_id' => $barangayAdmin->id],
            [
                'status' => Subscription::STATUS_ACTIVE,
                'amount' => 1500,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'payment_reference' => 'Seeded Barangay Bayuin subscription',
            ]
        );

        // Regular User (resident)
        User::updateOrCreate(
            ['email' => 'user@komunitech.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'), // change to secure password
                'role' => User::ROLE_USER,
                'barangay' => User::DEFAULT_BARANGAY,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
