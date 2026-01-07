<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    use HasFactory;

    const CAPACITY_KG = 100;
    const MAX_SYSTEM_CAPACITY_KG = 24500000;
    const TOTAL_SYSTEM_VAULTS = 245000; // 24,500,000 / 100

    protected $fillable = [
        'vault_identifier',
        'user_id',
        'capacity',
        'status', // 'available', 'assigned', 'maintenance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
