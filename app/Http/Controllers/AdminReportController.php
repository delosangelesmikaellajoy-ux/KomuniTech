<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = DocumentRequest::query();

        if ($user->barangay) {
            $query->where('barangay', $user->barangay);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(20)->withQueryString();
        $serviceFees = $query->where('status', 'Approved')->sum('service_fee');
        $totalRevenue = $query->sum('service_fee');

        return view('admin.reports.index', compact('requests', 'serviceFees', 'totalRevenue'));
    }

    public function export(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $query = DocumentRequest::query();

        if ($user->barangay) {
            $query->where('barangay', $user->barangay);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $filename = 'document_request_report_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Request ID',
                'Full Name',
                'Document Type',
                'Barangay',
                'Base Price',
                'Service Fee',
                'Total Amount',
                'Payment Method',
                'Payment Status',
                'Status',
                'Created At',
            ]);

            foreach ($query->cursor() as $request) {
                fputcsv($handle, [
                    $request->id,
                    $request->fullname,
                    $request->document_type,
                    $request->barangay,
                    number_format($request->base_price, 2),
                    number_format($request->service_fee, 2),
                    number_format($request->total_amount, 2),
                    $request->payment_method,
                    $request->payment_status,
                    $request->status,
                    $request->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
