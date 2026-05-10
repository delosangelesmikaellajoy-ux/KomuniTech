<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BarangayAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'barangayadmin@komunitech.com'],
            [
                'name' => 'Barangay Admin',
                'password' => Hash::make('password123'),
                'role' => \App\Models\User::ROLE_ADMIN,
                'barangay' => 'Sample Barangay',
                'is_seeder' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
