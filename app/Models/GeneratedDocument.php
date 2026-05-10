<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_request_id',
        'document_type_id',
        'html_content',
    ];

    public function documentRequest()
    {
        return $this->belongsTo(DocumentRequest::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
