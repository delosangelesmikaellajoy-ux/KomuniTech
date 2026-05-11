<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::where('barangay', Auth::user()->barangay)->get();
        return view('admin.document_types.index', compact('documentTypes'));
    }

    public function create()
    {
        return view('admin.document_types.create', [
            'documentType' => new DocumentType([
                'template_html' => $this->getDefaultTemplate('Document Type'),
                'editable_template_content' => $this->getDefaultTemplate('Document Type'),
                'template_file_type' => 'docx',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Check for duplicate name within the same barangay
        $existing = DocumentType::where('barangay', Auth::user()->barangay)
            ->where('name', $request->name)
            ->first();

        if ($existing) {
            return back()->withInput()->withErrors([
                'name' => 'A document type with this name already exists for your barangay.'
            ]);
        }

        DocumentType::create([
            'name' => $request->name,
            'base_price' => $request->base_price,
            'is_active' => $request->has('is_active'),
            'barangay' => Auth::user()->barangay,
            'template_html' => '<h1>' . e($request->name) . '</h1><p>Document for: {{ fullname }}</p><p>Address: {{ address }}</p><p>Purpose: {{ purpose }}</p><p>Release Date: {{ release_date }}</p>',
        ]);

        return redirect()->route('admin.document_types.index')->with('success', 'Document type created successfully.');
    }

    public function edit(DocumentType $documentType)
    {
        abort_unless($documentType->barangay === Auth::user()->barangay, 403);
        return view('admin.document_types.edit', compact('documentType'));
    }

    public function update(Request $request, DocumentType $documentType)
    {
        abort_unless($documentType->barangay === Auth::user()->barangay, 403);

        $allowedExtensions = ['doc', 'docx', 'pdf', 'xls', 'xlsx'];

        $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'template_file' => 'nullable|file|mimes:doc,docx,pdf,xls,xlsx|max:20480',
            'template_mode' => 'required|in:word,pdf,spreadsheet',
            'editable_template_content' => 'nullable|string',
            'template_html' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Check for duplicate name within the same barangay (excluding current document type)
        $existing = DocumentType::where('barangay', Auth::user()->barangay)
            ->where('name', $request->name)
            ->where('id', '!=', $documentType->id)
            ->first();

        if ($existing) {
            return back()->withInput()->withErrors([
                'name' => 'A document type with this name already exists for your barangay.'
            ]);
        }

        $templateFileData = [
            'template_file_path' => $documentType->template_file_path,
            'template_file_name' => $documentType->template_file_name,
            'template_file_mime' => $documentType->template_file_mime,
            'template_file_type' => $documentType->template_file_type,
            'template_file_size' => $documentType->template_file_size,
        ];

        if ($request->hasFile('template_file')) {
            if ($documentType->template_file_path) {
                Storage::disk('public')->delete($documentType->template_file_path);
            }

            $uploadedFile = $request->file('template_file');
            $templateFileType = strtolower($uploadedFile->extension());

            abort_unless(in_array($templateFileType, $allowedExtensions, true), 422, 'Unsupported template file type.');

            $safeBaseName = Str::slug($request->name ?: 'document-template');
            $fileName = $safeBaseName . '-' . Str::random(10) . '.' . $templateFileType;

            $templateFileData = [
                'template_file_path' => $uploadedFile->storeAs('document_templates/' . Auth::id(), $fileName, 'public'),
                'template_file_name' => $uploadedFile->getClientOriginalName(),
                'template_file_mime' => $uploadedFile->getMimeType(),
                'template_file_type' => $templateFileType,
                'template_file_size' => $uploadedFile->getSize(),
            ];
        }

        $editableTemplateContent = $request->input('editable_template_content')
            ?: $request->input('template_html')
            ?: $documentType->editable_template_content
            ?: $this->getDefaultTemplate($request->name);

        $documentType->update([
            'name' => $request->name,
            'base_price' => $request->base_price,
            'template_html' => $editableTemplateContent,
            'editable_template_content' => $editableTemplateContent,
            ...$templateFileData,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.document_types.index')->with('success', 'Document type updated successfully.');
    }

    public function destroy(DocumentType $documentType)
    {
        abort_unless($documentType->barangay === Auth::user()->barangay, 403);

        if ($documentType->template_file_path) {
            Storage::disk('public')->delete($documentType->template_file_path);
        }

        $documentType->delete();
        return redirect()->route('admin.document_types.index')->with('success', 'Document type deleted successfully.');
    }

    protected function getDefaultTemplate(string $name): string
    {
        return "<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\n<h1>{$name}</h1>\n<p><strong>Full Name:</strong> {{ fullname }}</p>\n<p><strong>Date of Birth:</strong> {{ dob }}</p>\n<p><strong>Sex:</strong> {{ sex }}</p>\n<p><strong>Civil Status:</strong> {{ civil_status }}</p>\n<p><strong>Address:</strong> {{ address }}</p>\n<p><strong>Barangay:</strong> {{ barangay }}</p>\n<p><strong>Purpose:</strong> {{ purpose }}</p>\n<p><strong>ID Presented:</strong> {{ id_presented }}</p>\n<p><strong>Contact Number:</strong> {{ contact_number }}</p>\n<p><strong>Release Date:</strong> {{ release_date }}</p>\n</div>";
    }
}