<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangayClearanceController;
use App\Http\Controllers\BarangayHealthCertificatesController;
use App\Http\Controllers\BusinessPermitController;
use App\Http\Controllers\IndengencyCertificatesController;
use App\Http\Controllers\RequestListController;
use App\Http\Controllers\RequestStatusController;
use App\Http\Controllers\ResidencyCertificatesController;

// Default redirect to get-started
Route::get('/', fn() => redirect('/get-started'));

// Role selection page
Route::get('/get-started', function () {
    return Inertia::render('LoginInterface');
});

// Role selection link -> saves role in session
// Route::get('/select-role/{role}', function ($role) {
//     if (!in_array($role, ['admin', 'user'])) {
//         abort(404);
//     }
//     session(['login_role' => $role]);
//     return redirect()->route('login');
// })->name('select.role');

Route::get('/select-role/{role}', function ($role) {
    if (!in_array($role, ['admin', 'user'])) {
        abort(404);
    }

    session(['login_role' => $role]);

    return $role === 'admin'
        ? redirect()->route('login.admin')
        : redirect()->route('login.user');
})->name('select.role');

Route::get('/login/admin', function () {
    return Inertia::render('LoginPage/Administrator');
})->name('login.admin');

Route::get('/login/user', function () {
    return Inertia::render('LoginPage/Resident');
})->name('login.user');

// Registration page
Route::get('/registration', fn() => Inertia::render('LoginPage/ApplyRegistration'));

// Custom login route to override Fortify default
Route::post('/login', [LoginController::class, 'store']);

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/request/list', [RequestListController::class, 'index'])->name('request.list');
    Route::get('/residents/list', [AdminController::class, 'residents'])->name('resident.lists');
    Route::get('/processing/list', [RequestListController::class, 'processing_request'])->name('processing.list');
    Route::get('/ready_to_pick_up/list', [RequestListController::class, 'ready_to_pick_up_request'])->name('ready_to_pick_up.list');
    Route::get('/released/list', [RequestListController::class, 'released_request'])->name('released.list');
});

// User-only routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [ResidentController::class, 'index'])->name('resident.dashboard');
    Route::get('/barangay/clearance', [BarangayClearanceController::class, 'index'])->name('barangay.clearance');
    Route::get('/business/permit', [BusinessPermitController::class, 'index'])->name('business.permit');
    Route::get('/barangay/health/certificates', [BarangayHealthCertificatesController::class, 'index'])->name('barangay.health.certificates');
    Route::get('/residency/certificates', [ResidencyCertificatesController::class, 'index'])->name('residency.certificates');
    Route::get('/indengency/certificates', [IndengencyCertificatesController::class, 'index'])->name('indengency.certificates');
    Route::get('/request/status', [RequestStatusController::class, 'index'])->name('request.status');
});
