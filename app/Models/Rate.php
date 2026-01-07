<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'rate',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];
} 