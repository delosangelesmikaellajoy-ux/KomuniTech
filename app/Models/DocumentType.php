<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay',
        'name',
        'base_price',
        'template_html',
        'template_file_path',
        'template_file_name',
        'template_file_mime',
        'template_file_type',
        'template_file_size',
        'editable_template_content',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    public function getEffectiveTemplateHtmlAttribute(): string
    {
        return $this->editable_template_content
            ?: $this->template_html
            ?: '<h1>' . e($this->name) . '</h1>';
    }

    public function getTemplateFileUrlAttribute(): ?string
    {
        if (! $this->template_file_path) {
            return null;
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->template_file_path);
    }

    public function getTemplateEditorModeAttribute(): string
    {
        return match ($this->template_file_type) {
            'xls', 'xlsx' => 'spreadsheet',
            'pdf' => 'pdf',
            'doc', 'docx' => 'word',
            default => 'word',
        };
    }
}
