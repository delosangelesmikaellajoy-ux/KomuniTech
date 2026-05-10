<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\DocumentType;
use App\Models\GeneratedDocument;
use App\Models\Transaction;
use App\Models\RequestHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    // Show create form
    public function create()
    {
        $documentTypes = \App\Models\DocumentType::where('barangay', Auth::user()->barangay)
            ->where('is_active', true)
            ->get();

        return view('documents.request.create', compact('documentTypes'));
    }

    // Store request with payment selection and optional GCash proof/reference
    public function store(Request $request)
    {
        if (! Auth::user()->barangay) {
            return redirect()->route('profile.edit')
                ->withErrors(['barangay' => 'Your account must be assigned a barangay before requesting documents.'])
                ->withInput();
        }

        $validated = $request->validate([
            'fullname'          => 'required|string|max:255',
            'dob'               => 'required|date',
            'sex'               => 'required|in:Male,Female',
            'civil_status'      => 'required|in:Single,Married,Widowed,Separated',
            'address'           => 'required|string|max:500',
            'document_type_id'  => 'required|exists:document_types,id',
            'purpose'           => 'required|string|max:255',
            'id_presented'      => 'required|string|max:255',
            'contact_number'    => 'required|string|max:30',
            'id_photo'          => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'payment_method'    => 'required|in:GCash,COD',
            'gcash_reference'   => 'nullable|string|max:255',
            'gcash_proof'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Verify the document type belongs to user's barangay and is active
        $documentType = \App\Models\DocumentType::where('id', $validated['document_type_id'])
            ->where('barangay', Auth::user()->barangay)
            ->where('is_active', true)
            ->first();

        if (! $documentType) {
            return back()->withErrors(['document_type_id' => 'Invalid document type selected.'])->withInput();
        }

        $validated['user_id'] = Auth::id();
        $validated['barangay'] = Auth::user()->barangay;
        $validated['document_type'] = $documentType->name; // Keep for backward compatibility
        $validated['base_price'] = $documentType->base_price;
        $validated['service_fee'] = DocumentRequest::SERVICE_FEE;
        $validated['total_amount'] = $validated['base_price'] + $validated['service_fee'];
        $validated['id_photo'] = $request->file('id_photo')->store('id_photos', 'public');

        // Set centralized payment status based on selected payment method
        $validated['payment_status'] = $validated['payment_method'] === 'COD'
            ? 'Pay on Pickup/Delivery'
            : 'Pending Verification';

        if ($validated['payment_method'] !== 'GCash') {
            // Clear GCash fields when COD is selected to keep records consistent
            $validated['gcash_reference'] = null;
            $validated['gcash_proof'] = null;
        }

        if ($request->hasFile('gcash_proof') && $validated['payment_method'] === 'GCash') {
            $validated['gcash_proof'] = $request->file('gcash_proof')->store('gcash_proofs', 'public');
        }

        $documentRequest = DocumentRequest::create($validated);

        RequestHistory::create([
            'document_request_id' => $documentRequest->id,
            'caused_by_user_id'   => Auth::id(),
            'action'              => 'Created',
            'remarks'             => 'Request submitted by user',
        ]);

        return redirect()
            ->route('document_requests.pending')
            ->with('success', 'Your request has been submitted. Please wait for verification.');
    }

    // User: view own pending requests
    public function pending()
    {
        $requests = DocumentRequest::where('user_id', Auth::id())
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);

        return view('documents.request.index', compact('requests'));
    }

    // ✅ User: cancel own pending request
    public function cancel(DocumentRequest $documentRequest)
    {
        if ($documentRequest->user_id !== Auth::id()) {
            return redirect()->route('user.dashboard')
                ->withErrors('You are not authorized to cancel this request.');
        }

        if ($documentRequest->status !== 'Pending') {
            return redirect()->route('user.dashboard')
                ->withErrors('Only pending requests can be cancelled.');
        }

        $documentRequest->update([
            'status' => 'Cancelled',
            'remarks' => 'Cancelled by user',
        ]);

        RequestHistory::create([
            'document_request_id' => $documentRequest->id,
            'caused_by_user_id'   => Auth::id(),
            'action'              => 'Cancelled',
            'remarks'             => 'Request cancelled by user',
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Request cancelled successfully.');
    }


    // User: view request history
    public function history()
    {
        $requests = DocumentRequest::where('user_id', Auth::id())
            ->whereIn('status', ['Approved', 'Rejected'])
            ->latest()
            ->paginate(10);

        return view('documents.request.history', compact('requests'));
    }

    // Admin: default Manage Requests (Pending only)
    public function adminIndex()
    {
        $user = Auth::user();
        $requests = DocumentRequest::forBarangay($user->barangay)
            ->where('status', 'Pending')
            ->latest()
            ->paginate(20);

        return view('admin.document_requests.index', compact('requests'));
    }

    // ✅ Admin: filtered requests
    public function adminPending()
    {
        $user = Auth::user();
        $requests = DocumentRequest::forBarangay($user->barangay)
            ->where('status', 'Pending')
            ->latest()
            ->paginate(20);

        return view('admin.document_requests.index', compact('requests')); // stays in Manage Requests
    }

    public function adminApproved()
    {
        $user = Auth::user();
        $requests = DocumentRequest::forBarangay($user->barangay)
            ->where('status', 'Approved')
            ->latest()
            ->paginate(20);

        return view('admin.document_requests.approved', compact('requests')); // separate page
    }

    public function adminRejected()
    {
        $user = Auth::user();
        $requests = DocumentRequest::forBarangay($user->barangay)
            ->where('status', 'Rejected')
            ->latest()
            ->paginate(20);

        return view('admin.document_requests.rejected', compact('requests')); // separate page
    }

    // Admin: update status + release date and optionally verify payment for GCash
    public function updateStatus(Request $request, DocumentRequest $documentRequest)
    {
        $request->validate([
            'status'         => 'required|in:Pending,Approved,Rejected',
            'remarks'        => 'nullable|string|max:500',
            'release_date'   => 'nullable|date|after_or_equal:today',
            'payment_status' => 'nullable|in:Pending Verification,Pay on Pickup/Delivery,Verified',
        ]);

        if ($request->status === 'Rejected' && empty(trim($request->remarks))) {
            return back()
                ->withErrors(['remarks' => 'Remarks are required when rejecting a request.'])
                ->withInput();
        }

        $updateData = [
            'status'       => $request->status,
            'remarks'      => $request->remarks,
            'release_date' => $request->status === 'Approved' ? $request->release_date : null,
        ];

        // Centralized payment handling: verify GCash only when approval occurs,
        // keep COD as Pay on Pickup/Delivery, and apply manual override if provided.
        if ($documentRequest->payment_method === 'GCash') {
            if ($request->filled('payment_status')) {
                $updateData['payment_status'] = $request->payment_status;
            } elseif ($request->status === 'Approved') {
                $updateData['payment_status'] = 'Verified';
            }
        }

        if ($documentRequest->payment_method === 'COD') {
            $updateData['payment_status'] = 'Pay on Pickup/Delivery';
        }

        $wasApproved = $documentRequest->status !== 'Approved' && $request->status === 'Approved';

        $documentRequest->update($updateData);

        if ($wasApproved) {
            $documentRequest->generatedDocument()->updateOrCreate([
                'document_request_id' => $documentRequest->id,
            ], [
                'document_type_id' => $documentRequest->document_type_id,
                'html_content' => $this->generateFinalDocumentHtml($documentRequest),
            ]);

            Transaction::create([
                'user_id' => Auth::id(),
                'document_request_id' => $documentRequest->id,
                'type' => Transaction::TYPE_SERVICE_FEE,
                'amount' => $documentRequest->service_fee,
                'status' => Transaction::STATUS_COMPLETED,
                'description' => 'Service fee recorded on approved document request #' . $documentRequest->id,
                'document_type' => $documentRequest->document_type,
                'barangay' => $documentRequest->barangay,
                'base_price' => $documentRequest->base_price,
                'service_fee' => $documentRequest->service_fee,
                'total_amount' => $documentRequest->total_amount,
                'payment_status' => $documentRequest->payment_status,
            ]);
        }

        RequestHistory::create([
            'document_request_id' => $documentRequest->id,
            'caused_by_user_id'   => Auth::id(),
            'action'              => $request->status,
            'remarks'             => $request->remarks,
        ]);

        return back()->with('success', 'Request status updated successfully!');
    }

    public function previewGenerated(DocumentRequest $documentRequest)
    {
        abort_unless($documentRequest->status === 'Approved', 403);
        abort_unless($documentRequest->barangay === Auth::user()->barangay, 403);

        $generated = $documentRequest->generatedDocument;
        $generatedHtml = $generated?->html_content ?? $this->generateFinalDocumentHtml($documentRequest);

        return view('admin.document_requests.preview', compact('documentRequest', 'generatedHtml'));
    }

    public function downloadGenerated(DocumentRequest $documentRequest, string $format)
    {
        abort_unless($documentRequest->status === 'Approved', 403);
        abort_unless($documentRequest->barangay === Auth::user()->barangay, 403);

        $generated = $documentRequest->generatedDocument;
        $html = $generated?->html_content ?? $this->generateFinalDocumentHtml($documentRequest);
        $filename = 'document_' . $documentRequest->id;

        if ($format === 'word') {
            return response($html)
                ->header('Content-Type', 'application/msword')
                ->header('Content-Disposition', "attachment; filename=\"{$filename}.doc\"");
        }

        return back()->withErrors('Unsupported format requested.');
    }

    protected function generateFinalDocumentHtml(DocumentRequest $documentRequest): string
    {
        $template = $documentRequest->documentType?->template_html;
        if (! $template) {
            $template = '<h1>' . e($documentRequest->document_type) . '</h1>' .
                '<p><strong>Name:</strong> ' . e($documentRequest->fullname) . '</p>' .
                '<p><strong>Barangay:</strong> ' . e($documentRequest->barangay) . '</p>' .
                '<p><strong>Address:</strong> ' . e($documentRequest->address) . '</p>' .
                '<p><strong>Purpose:</strong> ' . e($documentRequest->purpose) . '</p>' .
                '<p><strong>Release Date:</strong> ' . e($documentRequest->release_date?->format('Y-m-d') ?? 'N/A') . '</p>';
        }

        $fields = [
            '{{ fullname }}' => e($documentRequest->fullname),
            '{{ dob }}' => e($documentRequest->dob->format('Y-m-d')),
            '{{ sex }}' => e($documentRequest->sex),
            '{{ civil_status }}' => e($documentRequest->civil_status),
            '{{ address }}' => e($documentRequest->address),
            '{{ barangay }}' => e($documentRequest->barangay),
            '{{ document_type }}' => e($documentRequest->document_type),
            '{{ purpose }}' => e($documentRequest->purpose),
            '{{ id_presented }}' => e($documentRequest->id_presented),
            '{{ contact_number }}' => e($documentRequest->contact_number),
            '{{ payment_method }}' => e($documentRequest->payment_method),
            '{{ payment_status }}' => e($documentRequest->payment_status),
            '{{ base_price }}' => '₱' . number_format($documentRequest->base_price, 2),
            '{{ service_fee }}' => '₱' . number_format($documentRequest->service_fee, 2),
            '{{ total_amount }}' => '₱' . number_format($documentRequest->total_amount, 2),
            '{{ release_date }}' => e($documentRequest->release_date?->format('Y-m-d') ?? 'N/A'),
        ];

        $html = str_replace(array_keys($fields), array_values($fields), $template);

        return '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Generated Document</title></head><body>' . $html . '</body></html>';
    }
}
