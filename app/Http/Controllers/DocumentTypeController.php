<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::where('barangay', Auth::user()->barangay)->get();
        return view('admin.document_types.index', compact('documentTypes'));
    }

    public function create()
    {
        return view('admin.document_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'template_html' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        DocumentType::create([
            'name' => $request->name,
            'base_price' => $request->base_price,
            'template_html' => $request->template_html ?: $this->getDefaultTemplate($request->name),
            'is_active' => $request->has('is_active'),
            'barangay' => Auth::user()->barangay,
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

        $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'template_html' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $documentType->update([
            'name' => $request->name,
            'base_price' => $request->base_price,
            'template_html' => $request->template_html ?: $this->getDefaultTemplate($request->name),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.document_types.index')->with('success', 'Document type updated successfully.');
    }

    public function destroy(DocumentType $documentType)
    {
        abort_unless($documentType->barangay === Auth::user()->barangay, 403);
        $documentType->delete();
        return redirect()->route('admin.document_types.index')->with('success', 'Document type deleted successfully.');
    }

    protected function getDefaultTemplate(string $name): string
    {
        return "<h1>{$name}</h1>
<p><strong>Full Name:</strong> {{ fullname }}</p>
<p><strong>Date of Birth:</strong> {{ dob }}</p>
<p><strong>Sex:</strong> {{ sex }}</p>
<p><strong>Civil Status:</strong> {{ civil_status }}</p>
<p><strong>Address:</strong> {{ address }}</p>
<p><strong>Barangay:</strong> {{ barangay }}</p>
<p><strong>Purpose:</strong> {{ purpose }}</p>
<p><strong>ID Presented:</strong> {{ id_presented }}</p>
<p><strong>Contact Number:</strong> {{ contact_number }}</p>
<p><strong>Release Date:</strong> {{ release_date }}</p>";
    }
}