<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AdminLeaveController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\BirthdayController;

// Public routes
Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/team', function () {
    return view('team');
})->name('team');

// Guest only routes (redirect if already logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginShow'])->name('login.show');
    Route::post('/login', [AuthController::class, 'loginStore'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'registerShow'])->name('register.show');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register.submit');

    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordShow'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPasswordStore'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordShow'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPasswordStore'])->name('password.update');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Staff Approval System
    Route::get('/pending-staff', [AdminController::class, 'showPendingStaff'])->name('pending-staff');
    Route::post('/approve-staff/{id}', [AdminController::class, 'approveStaff'])->name('approve-staff');
    Route::post('/reject-staff/{id}', [AdminController::class, 'rejectStaff'])->name('reject-staff');

    // Staff Management
    Route::get('/all-staff', [AdminController::class, 'showAllStaff'])->name('all-staff');
    Route::get('/view-staff/{id}', [AdminController::class, 'viewStaff'])->name('view-staff');
    Route::get('/edit-staff/{id}', [AdminController::class, 'editStaff'])->name('edit-staff');
    Route::post('/update-staff/{id}', [AdminController::class, 'updateStaff'])->name('update-staff');
    Route::post('/deactivate-staff/{id}', [AdminController::class, 'deactivateStaff'])->name('deactivate-staff');
    Route::post('/reactivate-staff/{id}', [AdminController::class, 'reactivateStaff'])->name('reactivate-staff');

    // Team Staff route
    Route::get('/team-staff', [AdminController::class, 'showTeamStaff'])->name('team-staff');

    //  DECLARE UPDATE ENTITLEMENT ROUTE HERE (OUTSIDE nested prefix group)
    Route::post('/leave/update-entitlement/{id}', [AdminLeaveController::class, 'updateEntitlement'])->name('leave.update-entitlement');

    // ADMIN LEAVE MANAGEMENT ROUTES
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/', [AdminLeaveController::class, 'index'])->name('index');
        Route::get('/pending', [AdminLeaveController::class, 'pendingApplications'])->name('pending');
        Route::get('/all-applications', [AdminLeaveController::class, 'allApplications'])->name('all-applications');
        Route::get('/by-date', [AdminLeaveController::class, 'leaveByDate'])->name('by-date');
        Route::get('/application/{id}', [AdminLeaveController::class, 'show'])->name('show');
        Route::post('/approve/{id}', [AdminLeaveController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [AdminLeaveController::class, 'reject'])->name('reject');
        Route::post('/cancel-approved/{id}', [AdminLeaveController::class, 'cancelApproved'])->name('cancel-approved');
        Route::get('/staff-entitlements', [AdminLeaveController::class, 'staffEntitlements'])->name('staff-entitlements');
        Route::get('/intern-entitlements', [AdminLeaveController::class, 'internEntitlements'])->name('intern-entitlements');
        Route::get('/apply-for-staff', [AdminLeaveController::class, 'applyForStaff'])->name('apply-for-staff');
        Route::post('/apply-for-staff', [AdminLeaveController::class, 'storeForStaff'])->name('store-for-staff');
        Route::get('/download/{id}', [AdminLeaveController::class, 'downloadAttachment'])->name('download-attachment');
    });
});

// ============================================
// STAFF ROUTES
// ============================================
Route::middleware(['auth', CheckRole::class . ':staff,part_time,staff_ge'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/team-staff', [StaffController::class, 'showTeamStaff'])->name('team-staff');
});


// ============================================
// PROFILE ROUTES (All authenticated users)
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo'); // FIXED PATH
});

// ============================================
// LEAVE ROUTES (Admin & Staff can access)
// ============================================
Route::middleware('auth')->prefix('leave')->name('leave.')->group(function () {
    Route::get('/', [LeaveController::class, 'index'])->name('index');
    Route::get('/apply', [LeaveController::class, 'create'])->name('apply');
    Route::post('/apply', [LeaveController::class, 'store'])->name('store');
    Route::post('/check-daily-limit', [LeaveController::class, 'checkDailyLimit']);
    Route::get('/my-applications', [LeaveController::class, 'myApplications'])->name('my-applications');
    Route::get('/application/{id}', [LeaveController::class, 'show'])->name('show');
    Route::post('/cancel/{id}', [LeaveController::class, 'cancel'])->name('cancel');
    Route::post('/cancel-approved/{id}', [LeaveController::class, 'cancelApproved'])->name('cancel-approved'); //  ADDED
    Route::get('/download/{id}', [LeaveController::class, 'downloadAttachment'])->name('download-attachment');
});

// ============================================
// CALENDAR ROUTES (Admin & Staff can view)
// ============================================
Route::middleware('auth')->prefix('calendar')->name('calendar.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('index');
    Route::get('/data', [CalendarController::class, 'getCalendarDataJson'])->name('data');

    // Admin/Superadmin Only: Add/Delete Events (role check in controller)
    Route::post('/event/store', [CalendarController::class, 'storeEvent'])->name('event.store');
    Route::delete('/event/{id}', [CalendarController::class, 'deleteEvent'])->name('event.delete');
});

// ============================================
// INTERN ROUTES (Protected by intern role)
// ============================================
Route::middleware(['auth', CheckRole::class . ':intern'])->group(function () {
    Route::get('/intern/dashboard', [InternController::class, 'dashboard'])->name('intern.dashboard');
    Route::get('/intern/team-staff', [InternController::class, 'teamStaff'])->name('intern.team-staff');
});

// ============================================
// BIRTHDAY ROUTES (All authenticated users)
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/birthdays', [BirthdayController::class, 'index'])->name('birthdays.index');
});
