<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PlanController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner', [TenantController::class, 'index'])->name('owner.dashboard');
    Route::post('/owner/tenants', [TenantController::class, 'store'])->name('owner.tenants.store');
    Route::put('/owner/tenants/{id}', [TenantController::class, 'update'])->name('owner.tenants.update');
    Route::delete('/owner/tenants/{id}', [TenantController::class, 'destroy'])->name('owner.tenants.destroy');

    Route::get('/owner/billing', [PlanController::class, 'index'])->name('owner.billing');
    Route::post('/owner/plans', [PlanController::class, 'store'])->name('owner.plans.store');
    Route::put('/owner/plans/{id}', [PlanController::class, 'update'])->name('owner.plans.update');
    Route::delete('/owner/plans/{id}', [PlanController::class, 'destroy'])->name('owner.plans.destroy');

    Route::get('/owner/settings', function() {
        return view('owner.settings');
    })->name('owner.settings');
});

Route::middleware(['auth', 'tenant.auth'])->group(function () {
    Route::get('/', function () {
        $tenant = tenant();
        $plan = $tenant && $tenant->plan_id ? \App\Models\Plan::on('mysql')->find($tenant->plan_id) : null;
        
        $totalEmployees = \App\Models\Employee::count();
        $onlineEmployees = \App\Models\Employee::whereIn('status', ['online', 'active'])->count();
        $idleEmployees = \App\Models\Employee::where('status', 'idle')->count();
        $offlineEmployees = \App\Models\Employee::whereIn('status', ['offline', ''])->orWhereNull('status')->count();
        
        $recentEmployees = \App\Models\Employee::with('department')->latest()->take(5)->get();
        
        return view('client.dashboard', compact('plan', 'tenant', 'totalEmployees', 'onlineEmployees', 'idleEmployees', 'offlineEmployees', 'recentEmployees'));
    })->name('dashboard');

    Route::get('/monitor/{user}', function ($user) {
        $data = \Illuminate\Support\Facades\Cache::get('agent_data_' . $user, [
            'user' => $user,
            'status' => 'offline',
            'window' => 'Unknown',
            'device' => 'Unknown',
            'screen' => ''
        ]);
        return view('client.detail', ['data' => $data]);
    });

    Route::get('/live', function () {
        return view('client.live');
    })->name('client.live');

    Route::resource('departments', \App\Http\Controllers\DepartmentController::class)->names([
        'index' => 'client.departments.index',
        'store' => 'client.departments.store',
        'update' => 'client.departments.update',
        'destroy' => 'client.departments.destroy',
    ]);
    
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->names([
        'index' => 'client.employees.index',
        'store' => 'client.employees.store',
        'update' => 'client.employees.update',
        'destroy' => 'client.employees.destroy',
    ]);
    Route::post('employees/{employee}/revoke', [\App\Http\Controllers\EmployeeController::class, 'revokeToken'])->name('client.employees.revoke');

    Route::get('/reports', [\App\Http\Controllers\Client\ReportController::class, 'index'])->name('client.reports.index');
    Route::get('/settings', [\App\Http\Controllers\Client\SettingController::class, 'index'])->name('client.settings.index');
    Route::put('/settings/profile', [\App\Http\Controllers\Client\SettingController::class, 'updateProfile'])->name('client.settings.profile');
    Route::put('/settings/password', [\App\Http\Controllers\Client\SettingController::class, 'updatePassword'])->name('client.settings.password');
});
