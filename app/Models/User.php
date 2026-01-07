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
            // #region agent log
            file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'User.php:99', 'message' => 'Fetching roles from database', 'data' => ['userId' => $this->id], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
            // #endregion
            return $this->roles()->pluck('name')->toArray();
        });
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'User.php:100', 'message' => 'hasRole called, checking cache', 'data' => ['userId' => $this->id, 'roleName' => $roleName], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
        // #endregion
        $roles = $this->getCachedRoles();
        $hasRole = in_array($roleName, $roles);

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'User.php:105', 'message' => 'hasRole result from cache', 'data' => ['userId' => $this->id, 'roleName' => $roleName, 'hasRole' => $hasRole, 'cachedRoles' => $roles], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
        // #endregion

        return $hasRole;
    }

    /**
     * Check if the user is a client.
     */
    public function isClient(): bool
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'User.php:100', 'message' => 'isClient called', 'data' => ['userId' => $this->id], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
        // #endregion
        return $this->hasRole(self::ROLE_CLIENT);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'User.php:108', 'message' => 'isAdmin called', 'data' => ['userId' => $this->id], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
        // #endregion
        return $this->hasRole(self::ROLE_ADMIN);
    }
}