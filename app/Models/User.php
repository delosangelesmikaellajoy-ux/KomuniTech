<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Add your role constants here
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_ADMINISTRATOR = 'administrator';

    // Convenience helper methods to check roles
    // ROLE_ADMINISTRATOR is the system owner with global configuration access.
    public function isAdministrator(): bool
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    // ROLE_ADMIN is a barangay-level operative for request processing.
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isSeeder(): bool
    {
        return $this->is_seeder === true;
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', Subscription::STATUS_ACTIVE)->latestOfMany();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function hasActiveSubscription(): bool
    {
        if ($this->isSeeder()) {
            return true;
        }

        $subscription = $this->subscription;

        return $subscription !== null && $subscription->isActive();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // add role here so you can mass assign it!
        'barangay',
        'is_seeder',
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
            'is_seeder' => 'boolean',
        ];
    }
}
