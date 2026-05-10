<?php

namespace App\Models;

use App\Models\DocumentType;
use App\Models\GeneratedDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullname',
        'dob',
        'sex',
        'civil_status',
        'address',
        'document_type',
        'document_type_id',
        'base_price',
        'service_fee',
        'total_amount',
        'barangay',
        'purpose',
        'id_presented',
        'contact_number',
        'status',
        'remarks',
        'id_photo',
        'release_date',
        'payment_method',
        'payment_status',
        'gcash_reference',
        'gcash_proof',
    ];

    protected $casts = [
        'dob' => 'date',
        'release_date' => 'date',
        'base_price' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'document_type_id' => 'integer',
    ];

    public const SERVICE_FEE = 20;

    public static function paymentMethods(): array
    {
        return ['GCash', 'COD'];
    }

    public static function paymentStatuses(): array
    {
        return ['Pending Verification', 'Pay on Pickup/Delivery', 'Verified'];
    }

    public function getTotalAmountAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        return $this->base_price + $this->service_fee;
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function generatedDocument()
    {
        return $this->hasOne(GeneratedDocument::class);
    }

    public function getDocumentTypeNameAttribute(): string
    {
        return $this->documentType?->name ?? $this->document_type;
    }

    public function scopeForBarangay($query, ?string $barangay)
    {
        if ($barangay) {
            return $query->where('barangay', $barangay);
        }

        return $query;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/DocumentRequest.php
    public function history()
    {
        return $this->hasMany(\App\Models\RequestHistory::class)->latest();
    }

}
