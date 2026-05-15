<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ─── Create Roles ───
        $adminRole    = Role::firstOrCreate(['name' => 'admin']);
        $residentRole = Role::firstOrCreate(['name' => 'resident']);

        // ─── Create Admin Account ───
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name'              => 'Admin User',
                'email'             => 'admin@test.com',
                'password'          => Hash::make('123456'),
                'email_verified_at' => now(),
                'contact'           => '09123456789',
                'address'           => 'Barangay New Kababae, Olongapo City',
            ]
        );
        $admin->assignRole('admin');

        // ─── Create Resident Account ───
        $resident = User::firstOrCreate(
            ['email' => 'resident@test.com'],
            [
                'name'              => 'Test Resident',
                'email'             => 'resident@test.com',
                'password'          => Hash::make('123456'),
                'email_verified_at' => now(),
                'contact'           => '09987654321',
                'address'           => 'Purok 1, Barangay New Kababae, Olongapo City',
            ]
        );
        $resident->assignRole('resident');
    }
}