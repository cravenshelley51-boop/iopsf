<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => User::ROLE_ADMIN]);
        
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@securevault.com',
            'password' => Hash::make('password'),
        ]);

        $user->roles()->attach($adminRole);
    }
} 