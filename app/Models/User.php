<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gold_balance',
        'balance_visibility',
        'pin_code',
        'pin_changed',
        'two_factor_secret',
        'two_factor_enabled',
        'notification_settings',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'pin_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_enabled' => 'boolean',
        'balance_visibility' => 'boolean',
        'pin_changed' => 'boolean',
        'notification_settings' => 'array',
        'last_login_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when user is updated
        static::saved(function ($user) {
            Cache::forget("user.{$user->id}.roles");
            Cache::forget("user.{$user->id}.data");
        });

        // Clear cache when user is deleted
        static::deleted(function ($user) {
            Cache::forget("user.{$user->id}.roles");
            Cache::forget("user.{$user->id}.data");
        });
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function goldTransactions()
    {
        return $this->hasMany(GoldTransaction::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function requiredDocuments()
    {
        return $this->hasMany(RequiredDocument::class);
    }

    public function vaults()
    {
        return $this->hasMany(Vault::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Clear user cache.
     */
    public function clearCache(): void
    {
        Cache::forget("user.{$this->id}.roles");
        Cache::forget("user.{$this->id}.data");
    }

    /**
     * Get cached user roles.
     */
    protected function getCachedRoles(): array
    {
        return Cache::remember("user.{$this->id}.roles", 3600, function () {


            return $this->roles()->pluck('name')->toArray();
        });
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {


        $roles = $this->getCachedRoles();
        $hasRole = in_array($roleName, $roles);




        return $hasRole;
    }

    /**
     * Check if the user is a client.
     */
    public function isClient(): bool
    {


        return $this->hasRole(self::ROLE_CLIENT);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {


        return $this->hasRole(self::ROLE_ADMIN);
    }
}