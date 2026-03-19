<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\Auth\SetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\LetterTemplateController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\IpRestrictionController;
use App\Http\Controllers\Admin\SalarySlipController as AdminSalarySlipController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\SalarySlipController as EmployeeSalarySlipController;
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Employee\LeaveController as EmployeeLeaveController;
use App\Http\Controllers\Employee\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Generic login route (redirects to admin login by default)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// Employee Authentication Routes
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [EmployeeLoginController::class, 'login']);
    Route::post('/logout', [EmployeeLoginController::class, 'logout'])->name('logout');
    
    // Set Password Routes
    Route::get('/set-password', [SetPasswordController::class, 'showSetPasswordForm'])->name('set-password.show');
    Route::post('/set-password', [SetPasswordController::class, 'setPassword'])->name('set-password');
});

// Admin Routes (Protected)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Role Management
    Route::resource('roles', RoleController::class);
    
    // Letter Management
    Route::resource('letters', LetterController::class);
    Route::post('/letters/{letter}/generate', [LetterController::class, 'generate'])->name('letters.generate');
    Route::get('/letters/template/{templateId}', [LetterController::class, 'getTemplate'])->name('letters.get-template');
    
    // Letter Template Management
    Route::resource('letter-templates', LetterTemplateController::class);
    Route::post('/letter-templates/preview', [LetterTemplateController::class, 'preview'])->name('letter-templates.preview');
    
    // Leave Management
    Route::resource('leaves', LeaveController::class);
    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    
    // IP Restriction Management
    Route::resource('ip-restrictions', IpRestrictionController::class);
    
    // Salary Slip Management
    Route::get('salary-slips/attendance-summary', [AdminSalarySlipController::class, 'getAttendanceSummary'])
        ->name('salary-slips.attendance-summary');
    Route::post('salary-slips/generate', [AdminSalarySlipController::class, 'generate'])
        ->name('salary-slips.generate');
    Route::post('salary-slips/bulk-generate', [AdminSalarySlipController::class, 'bulkGenerate'])
        ->name('salary-slips.bulk-generate');
    Route::get('salary-slips/{id}/preview', [AdminSalarySlipController::class, 'preview'])
        ->name('salary-slips.preview');
    Route::get('salary-slips/{id}/download', [AdminSalarySlipController::class, 'download'])
        ->name('salary-slips.download');
    Route::resource('salary-slips', AdminSalarySlipController::class)->except(['index', 'show']);
    Route::get('salary-slips', [AdminSalarySlipController::class, 'index'])->name('salary-slips.index');
    Route::get('salary-slips/{id}', [AdminSalarySlipController::class, 'show'])->name('salary-slips.show');
});

// Employee Routes (Protected)
Route::prefix('employee')->middleware(['auth', 'employee.password.set'])->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    
    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/punch-in', [AttendanceController::class, 'punchIn'])->name('attendance.punch-in');
    Route::post('/attendance/punch-out', [AttendanceController::class, 'punchOut'])->name('attendance.punch-out');
    Route::get('/attendance/calendar', [AttendanceController::class, 'calendar'])->name('attendance.calendar');
    
    // Leave Management
    Route::resource('leaves', EmployeeLeaveController::class)->except(['show', 'edit', 'update']);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    // Salary Slips
    Route::get('/salary-slips', [EmployeeSalarySlipController::class, 'index'])->name('salary-slips.index');
    Route::get('/salary-slips/{id}', [EmployeeSalarySlipController::class, 'show'])->name('salary-slips.show');
    Route::get('/salary-slips/{id}/preview', [EmployeeSalarySlipController::class, 'preview'])->name('salary-slips.preview');
    Route::get('/salary-slips/{id}/download', [EmployeeSalarySlipController::class, 'download'])->name('salary-slips.download');
});
