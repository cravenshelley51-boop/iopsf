<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vault;
use Illuminate\Support\Str;

class VaultSeeder extends Seeder
{
    public function run()
    {
        // Check if we already have vaults, to avoid duplicates on re-seed
        if (Vault::count() > 0) {
            return;
        }

        $vaults = [];
        // Total system capacity is 24,500,000 kg.
        // Each vault is 100kg.
        // Total vaults = 245,000.
        // For development/seeding performance, we'll create a subset (e.g., 1000).
        $limit = 1000;

        for ($i = 1; $i <= $limit; $i++) {
            $vaults[] = [
                'vault_identifier' => 'V-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'user_id' => null,
                'capacity' => 100.00,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Vault::insert($vaults);
    }
}
