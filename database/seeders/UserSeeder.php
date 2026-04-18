<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@balirealtyhv.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@balirealtyhv.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager@balirealtyhv.com'],
            [
                'name' => 'Manager',
                'email' => 'manager@balirealtyhv.com',
                'password' => Hash::make('manager123'),
                'role' => 'manager',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@balirealtyhv.com'],
            [
                'name' => 'Staff',
                'email' => 'staff@balirealtyhv.com',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
