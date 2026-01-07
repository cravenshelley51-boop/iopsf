<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'oforiattsah@gmail.com'],
            [
                'name' => 'Ofori Attsah',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'gold_balance' => 1,
            ]
        );
        $admin->roles()->sync([$adminRole->id]);

        // Create test client users
        $clients = [
            [
                'name' => 'Frederick C. Cordero',
                'email' => 'frederickcordero@gmail.com',
                'gold_balance' => 500,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'gold_balance' => 750,
            ],
            [
                'name' => 'Gregory Wilson',
                'email' => 'gregorywilson@gmail.com',
                'gold_balance' => 250,
            ],
            [
                'name' => 'FineStyle Company',
                'email' => 'finestylecompany@gmail.com',
                'gold_balance' => 1500,
            ]

        ];

        foreach ($clients as $clientData) {
            $client = User::firstOrCreate(
                ['email' => $clientData['email']],
                [
                    'name' => $clientData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'gold_balance' => $clientData['gold_balance'],
                ]
            );
            $client->roles()->sync([$clientRole->id]);
        }
    }
}
