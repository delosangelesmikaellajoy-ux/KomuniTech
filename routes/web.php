<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\DocumentRequestController;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Http\Controllers\DocumentRequestHistoryController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\AnnouncementController; // ✅ Import controller
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminReportController;
use App\Models\Transaction;

// ===============================
// Public route
// ===============================
Route::get('/', function () {
    return view('welcome');
});

// ===============================
// Utility route: generate password hash
// ===============================
Route::get('/generate-password', function () {
    return Hash::make('password123');
});

// ===============================
// Smart dashboard route: redirects based on role
// ===============================
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === User::ROLE_ADMINISTRATOR) {
        return redirect()->route('administrator.dashboard');
    }

    if ($role === User::ROLE_ADMIN) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ===============================
// Barangay Administrator dashboard & routes
// ===============================
Route::middleware(['auth', 'role:' . User::ROLE_ADMINISTRATOR])->group(function () {
    Route::get('/administrator/dashboard', function () {
        return view('administrator.dashboard');
    })->name('administrator.dashboard');

    Route::get('/administrator/barangays', [BarangayController::class, 'index'])
        ->name('administrator.barangays.index');

    Route::get('/administrator/barangay-admins', [BarangayController::class, 'admins'])
        ->name('administrator.barangay_admins.index');

    Route::get('/administrator/barangay-admins/create', [BarangayController::class, 'create'])
        ->name('administrator.barangay_admins.create');
    Route::post('/administrator/barangay-admins', [BarangayController::class, 'store'])
        ->name('administrator.barangay_admins.store');
});

// ===============================
// Barangay Admin dashboards & routes
// ===============================
Route::middleware(['auth', 'role:' . User::ROLE_ADMIN])->group(function () {
    Route::get('/admin/subscription', [SubscriptionController::class, 'status'])
        ->name('admin.subscription.status');
    Route::post('/admin/subscription/pay', [SubscriptionController::class, 'pay'])
        ->name('admin.subscription.pay');

    Route::middleware(['subscription.active'])->group(function () {
        Route::get('/admin/dashboard', function () {
            $user = auth()->user();
            $requests = DocumentRequest::query()->forBarangay($user->barangay);

            $pendingCount  = (clone $requests)->where('status', 'Pending')->count();
            $approvedCount = (clone $requests)->where('status', 'Approved')->count();
            $rejectedCount = (clone $requests)->where('status', 'Rejected')->count();
            $collectedServiceFees = (clone $requests)->where('status', 'Approved')->sum('service_fee');

            return view('admin.dashboard', compact('pendingCount', 'approvedCount', 'rejectedCount', 'collectedServiceFees'));
        })->name('admin.dashboard');

        // ✅ Filtered request routes
        Route::get('/admin/document-requests/pending', [DocumentRequestController::class, 'adminPending'])
            ->name('admin.document_requests.pending');
        Route::get('/admin/document-requests/approved', [DocumentRequestController::class, 'adminApproved'])
            ->name('admin.document_requests.approved');
        Route::get('/admin/document-requests/rejected', [DocumentRequestController::class, 'adminRejected'])
            ->name('admin.document_requests.rejected');

        Route::get('/admin/document-requests', [DocumentRequestController::class, 'adminIndex'])
            ->name('admin.document_requests.index');
        Route::patch('/admin/document-requests/{documentRequest}', [DocumentRequestController::class, 'updateStatus'])
            ->name('admin.document_requests.update');

        Route::get('/admin/reports', [AdminReportController::class, 'index'])
            ->name('admin.reports.index');
        Route::get('/admin/reports/export', [AdminReportController::class, 'export'])
            ->name('admin.reports.export');

        // Document Types Management
        Route::resource('admin/document-types', DocumentTypeController::class)->names([
            'index'   => 'admin.document_types.index',
            'create'  => 'admin.document_types.create',
            'store'   => 'admin.document_types.store',
            'edit'    => 'admin.document_types.edit',
            'update'  => 'admin.document_types.update',
            'destroy' => 'admin.document_types.destroy',
        ]);

        // Document Request Preview and Download
        Route::get('/admin/document-requests/{documentRequest}/preview', [DocumentRequestController::class, 'previewGenerated'])
            ->name('admin.document_requests.preview');
        Route::get('/admin/document-requests/{documentRequest}/download/{format}', [DocumentRequestController::class, 'downloadGenerated'])
            ->name('admin.document_requests.download');

        //Route::get('/admin/request-logs', [DocumentRequestHistoryController::class, 'adminAudit'])
            //->name('admin.request_logs.index');

        // ✅ Updated Announcement routes with explicit names
        Route::resource('admin/announcements', AnnouncementController::class)->names([
            'index'   => 'admin.announcements.index',
            'create'  => 'admin.announcements.create',
            'store'   => 'admin.announcements.store',
            'edit'    => 'admin.announcements.edit',
            'update'  => 'admin.announcements.update',
            'destroy' => 'admin.announcements.destroy',
            'show'    => 'admin.announcements.show',
        ]);
    });
});

// ===============================
// User dashboards & routes
// ===============================
Route::middleware(['auth', 'role:' . User::ROLE_USER])->group(function () {
    Route::get('/user/dashboard', [ProfileController::class, 'dashboard'])
        ->name('user.dashboard');

    Route::get('/requests/create', [DocumentRequestController::class, 'create'])
        ->name('document_requests.create');
    Route::post('/requests', [DocumentRequestController::class, 'store'])
        ->name('document_requests.store');

    Route::get('/requests', [DocumentRequestController::class, 'pending'])
        ->name('document_requests.pending');

    Route::get('/requests/history', [DocumentRequestController::class, 'history'])
        ->name('document_requests.history');

    // ✅ Cancel request route (only for pending requests)
    Route::patch('/requests/{documentRequest}/cancel', [DocumentRequestController::class, 'cancel'])
        ->name('document_requests.cancel');

    // ✅ User-facing announcements
    Route::get('/user/announcements', [AnnouncementController::class, 'userIndex'])
        ->name('user.announcements.index');
});

// ===============================
// Social login routes
// ===============================
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// ===============================
// Profile routes
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
