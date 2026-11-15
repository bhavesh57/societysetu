<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMonitoringController;
use App\Http\Controllers\Admin\AdminSocietyController;
use App\Http\Controllers\App\AppAuthController;
use App\Http\Controllers\App\CommitteeComplaintController;
use App\Http\Controllers\App\CommitteeDashboardController;
use App\Http\Controllers\App\CommitteeMemberController;
use App\Http\Controllers\App\CommitteeNewsletterController;
use App\Http\Controllers\App\CommitteePropertyController;
use App\Http\Controllers\App\OwnerComplaintController;
use App\Http\Controllers\App\OwnerDashboardController;
use App\Http\Controllers\App\OwnerNewsletterController;
use App\Http\Controllers\App\OwnerTenantController;
use App\Http\Controllers\App\TenantComplaintController;
use App\Http\Controllers\App\TenantDashboardController;
use App\Http\Controllers\App\TenantNewsletterController;
use Illuminate\Support\Facades\Route;

// Public Customer Website Landing Page (No Login Buttons)
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Super Admin Console (SSA Slug instead of admin)
|--------------------------------------------------------------------------
*/
Route::prefix('ssa')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Public / semi-private developer & API docs accessible under ssa/docs
    Route::get('/docs', [AdminDashboardController::class, 'docs'])->name('admin.docs');

    Route::middleware(['auth', 'super_admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Societies
        Route::get('/societies', [AdminSocietyController::class, 'index'])->name('admin.societies.index');
        Route::get('/societies/create', [AdminSocietyController::class, 'create'])->name('admin.societies.create');
        Route::post('/societies', [AdminSocietyController::class, 'store'])->name('admin.societies.store');
        Route::get('/societies/{society}', [AdminSocietyController::class, 'show'])->name('admin.societies.show');
        Route::get('/societies/{society}/edit', [AdminSocietyController::class, 'edit'])->name('admin.societies.edit');
        Route::put('/societies/{society}', [AdminSocietyController::class, 'update'])->name('admin.societies.update');
        Route::post('/societies/{society}/toggle-status', [AdminSocietyController::class, 'toggleStatus'])->name('admin.societies.toggle_status');
        Route::post('/societies/{society}/committee', [AdminSocietyController::class, 'addCommitteeMember'])->name('admin.societies.add_committee');

        // Global Monitoring
        Route::get('/monitoring', [AdminMonitoringController::class, 'index'])->name('admin.monitoring');
    });
});

// Redirect legacy /admin URLs to /ssa
Route::redirect('/admin', '/ssa/login');
Route::redirect('/admin/login', '/ssa/login');
Route::redirect('/admin/dashboard', '/ssa/dashboard');

/*
|--------------------------------------------------------------------------
| Mobile App Portal (NativePHP Mobile Shell & WebView)
|--------------------------------------------------------------------------
*/
Route::prefix('app')->group(function () {
    Route::get('/login', [AppAuthController::class, 'showLogin'])->name('app.login');
    Route::post('/login', [AppAuthController::class, 'login'])->name('app.login.submit');
    Route::post('/logout', [AppAuthController::class, 'logout'])->name('app.logout');
    Route::get('/switch-role/{role}', [AppAuthController::class, 'switchRole'])->name('app.switch_role');

    // 1. Committee Member
    Route::middleware(['auth', 'society_member:committee_member'])->prefix('committee')->group(function () {
        Route::get('/', [CommitteeDashboardController::class, 'index'])->name('committee.dashboard');

        // Properties
        Route::get('/properties', [CommitteePropertyController::class, 'index'])->name('committee.properties.index');
        Route::get('/properties/create', [CommitteePropertyController::class, 'create'])->name('committee.properties.create');
        Route::post('/properties', [CommitteePropertyController::class, 'store'])->name('committee.properties.store');

        // Members & Directory
        Route::get('/members', [CommitteeMemberController::class, 'directory'])->name('committee.members.directory');
        Route::post('/members/owner', [CommitteeMemberController::class, 'storeOwner'])->name('committee.members.store_owner');
        Route::post('/members/tenant', [CommitteeMemberController::class, 'storeTenant'])->name('committee.members.store_tenant');

        // Newsletters
        Route::get('/newsletters', [CommitteeNewsletterController::class, 'index'])->name('committee.newsletters.index');
        Route::get('/newsletters/create', [CommitteeNewsletterController::class, 'create'])->name('committee.newsletters.create');
        Route::post('/newsletters', [CommitteeNewsletterController::class, 'store'])->name('committee.newsletters.store');

        // Complaints
        Route::get('/complaints', [CommitteeComplaintController::class, 'index'])->name('committee.complaints.index');
        Route::get('/complaints/{complaint}', [CommitteeComplaintController::class, 'show'])->name('committee.complaints.show');
        Route::post('/complaints/{complaint}/status', [CommitteeComplaintController::class, 'updateStatus'])->name('committee.complaints.update_status');
    });

    // 2. House Owner
    Route::middleware(['auth', 'society_member:house_owner'])->prefix('owner')->group(function () {
        Route::get('/', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');

        // Tenants
        Route::get('/tenants', [OwnerTenantController::class, 'index'])->name('owner.tenants.index');
        Route::post('/tenants', [OwnerTenantController::class, 'store'])->name('owner.tenants.store');
        Route::post('/tenants/{tenant}/deactivate', [OwnerTenantController::class, 'deactivate'])->name('owner.tenants.deactivate');

        // Newsletters
        Route::get('/newsletters', [OwnerNewsletterController::class, 'index'])->name('owner.newsletters.index');
        Route::get('/newsletters/{newsletter}', [OwnerNewsletterController::class, 'show'])->name('owner.newsletters.show');

        // Complaints
        Route::get('/complaints', [OwnerComplaintController::class, 'index'])->name('owner.complaints.index');
        Route::get('/complaints/create', [OwnerComplaintController::class, 'create'])->name('owner.complaints.create');
        Route::post('/complaints', [OwnerComplaintController::class, 'store'])->name('owner.complaints.store');
        Route::get('/complaints/{complaint}', [OwnerComplaintController::class, 'show'])->name('owner.complaints.show');
    });

    // 3. Rental / Tenant
    Route::middleware(['auth', 'society_member:tenant'])->prefix('tenant')->group(function () {
        Route::get('/', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');

        // Newsletters
        Route::get('/newsletters', [TenantNewsletterController::class, 'index'])->name('tenant.newsletters.index');
        Route::get('/newsletters/{newsletter}', [TenantNewsletterController::class, 'show'])->name('tenant.newsletters.show');

        // Complaints
        Route::get('/complaints', [TenantComplaintController::class, 'index'])->name('tenant.complaints.index');
        Route::get('/complaints/create', [TenantComplaintController::class, 'create'])->name('tenant.complaints.create');
        Route::post('/complaints', [TenantComplaintController::class, 'store'])->name('tenant.complaints.store');
        Route::get('/complaints/{complaint}', [TenantComplaintController::class, 'show'])->name('tenant.complaints.show');
    });
});
