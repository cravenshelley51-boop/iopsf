<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    // Role constants
    public const ADMIN = 'admin';
    public const CLIENT = 'client';

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if the role is an admin role.
     */
    public function isAdmin(): bool
    {
        return $this->name === 'ADMIN';
    }

    /**
     * Check if the role is a client role.
     */
    public function isClient(): bool
    {
        return $this->name === 'CLIENT';
    }
}
