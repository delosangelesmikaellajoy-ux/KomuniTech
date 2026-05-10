<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'Pending';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_EXPIRED = 'Expired';

    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'starts_at',
        'expires_at',
        'payment_reference',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE && $this->expires_at && $this->expires_at->isFuture();
    }
}
