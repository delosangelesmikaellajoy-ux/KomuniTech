<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public const TYPE_SERVICE_FEE = 'service_fee';
    public const TYPE_SUBSCRIPTION_FEE = 'subscription_fee';

    public const STATUS_PENDING = 'Pending';
    public const STATUS_COMPLETED = 'Completed';
    public const STATUS_FAILED = 'Failed';

    protected $fillable = [
        'user_id',
        'document_request_id',
        'subscription_id',
        'type',
        'amount',
        'status',
        'description',
        'document_type',
        'barangay',
        'base_price',
        'service_fee',
        'total_amount',
        'payment_status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'base_price' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documentRequest()
    {
        return $this->belongsTo(DocumentRequest::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
