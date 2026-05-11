<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BarangayAdminSeeder extends Seeder
{
    public function run(): void
    {
        $barangayAdmin = User::updateOrCreate(
            ['email' => 'barangayadmin@komunitech.com'],
            [
                'name' => 'Barangay Admin',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_ADMIN,
                'barangay' => User::DEFAULT_BARANGAY,
                'is_seeder' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
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
    }
}
