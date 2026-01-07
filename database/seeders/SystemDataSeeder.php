<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rate;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SystemDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Sample Gold Rates
        $rates = [
            [
                'rate' => 2050.45,
                'valid_from' => Carbon::now()->subDays(2),
                'valid_to' => Carbon::now()->subDays(1),
            ],
            [
                'rate' => 2075.12,
                'valid_from' => Carbon::now()->subDays(1),
                'valid_to' => Carbon::now()->addDay(),
            ],
        ];

        foreach ($rates as $rateData) {
            Rate::updateOrCreate(
                ['valid_from' => $rateData['valid_from']],
                $rateData
            );
        }

        // 2. Create Sample Transactions for Clients
        $clients = User::whereHas('roles', function ($query) {
            $query->where('name', 'client');
        })->get();

        foreach ($clients as $client) {
            // Add a completed deposit
            Transaction::updateOrCreate(
                [
                    'user_id' => $client->id,
                    'description' => 'Initial Account Funding',
                ],
                [
                    'amount' => 5000.00,
                    'type' => Transaction::TYPE_DEPOSIT,
                    'status' => Transaction::STATUS_COMPLETED,
                    'payment_method' => Transaction::PAYMENT_METHOD_BANK_TRANSFER,
                ]
            );

            // Add a pending transaction
            Transaction::updateOrCreate(
                [
                    'user_id' => $client->id,
                    'description' => 'System Verification Transaction',
                ],
                [
                    'amount' => 150.75,
                    'type' => Transaction::TYPE_DEPOSIT,
                    'status' => Transaction::STATUS_PENDING,
                    'payment_method' => Transaction::PAYMENT_METHOD_BANK_TRANSFER,
                ]
            );
        }
    }
}
