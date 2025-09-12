<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'last_login',
        'locked_until',
        'is_active',
    ];

    protected $attributes = [
        'is_admin' => false,
        'is_active' => true,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'locked_until' => 'datetime',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Check if user account is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if user account is locked
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Lock user account for specified duration (in minutes)
     */
    public function lockAccount(int $minutes = 30): void
    {
        $this->update([
            'locked_until' => now()->addMinutes($minutes)
        ]);
    }

    /**
     * Unlock user account
     */
    public function unlockAccount(): void
    {
        $this->update([
            'locked_until' => null
        ]);
    }

    /**
     * Activate user account
     */
    public function activate(): void
    {
        $this->update([
            'is_active' => true
        ]);
    }

    /**
     * Deactivate user account
     */
    public function deactivate(): void
    {
        $this->update([
            'is_active' => false
        ]);
    }

    /**
     * Make user an admin
     */
    public function makeAdmin(): void
    {
        $this->update([
            'is_admin' => true
        ]);
    }

    /**
     * Remove admin privileges
     */
    public function removeAdmin(): void
    {
        $this->update([
            'is_admin' => false
        ]);
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update([
            'last_login' => now()
        ]);
    }

    /**
     * Get user status text
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        if ($this->isLocked()) {
            return 'Locked';
        }
        
        return 'Active';
    }

    /**
     * Get user role text
     */
    public function getRoleAttribute(): string
    {
        return $this->is_admin ? 'Admin' : 'User';
    }
}
