<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@bloghub.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create demo user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@bloghub.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}