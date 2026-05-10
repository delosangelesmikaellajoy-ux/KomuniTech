<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestHistory extends Model
{
    // Explicit table name
    protected $table = 'request_history';

    // Fillable fields
    protected $fillable = [
        'document_request_id',
        'caused_by_user_id',
        'action',
        'remarks',
    ];

    // Casts
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function request(): BelongsTo
    {
        return $this->belongsTo(DocumentRequest::class);
    }

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caused_by_user_id');
    }
}
