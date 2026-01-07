<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Ofori Attsah',
            'email' => 'oforiattsah@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach(Role::where('name', Role::ADMIN)->first());

        // Create client user
        $client = User::create([
            'name' => 'Frederick C. Cordero',
            'email' => 'frederickcordero@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $client->roles()->attach(Role::where('name', Role::CLIENT)->first());
    }
} 