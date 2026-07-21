<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PlanController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
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

    Route::get('/settings', [\App\Http\Controllers\Client\SettingController::class, 'index'])->name('client.settings.index');
    Route::put('/settings/profile', [\App\Http\Controllers\Client\SettingController::class, 'updateProfile'])->name('client.settings.profile');
    Route::put('/settings/password', [\App\Http\Controllers\Client\SettingController::class, 'updatePassword'])->name('client.settings.password');

    // Restricted Routes (Require Active Plan)
    Route::middleware(['plan.active'])->group(function () {
        Route::get('/monitor/{user}', function ($user) {
            $tenantId = tenant('id');
            $cacheKey = 'agent_data_' . ($tenantId ? $tenantId . '_' : '') . $user;
            $data = \Illuminate\Support\Facades\Cache::get($cacheKey, [
                'user' => $user,
                'status' => 'offline',
                'window' => 'Unknown',
                'device' => 'Unknown',
                'screen' => ''
            ]);
            $screenshots = \App\Models\EmployeeScreenshot::where('employee_id', $user)
                                ->orderBy('captured_at', 'desc')->take(20)->get();
            $alerts = \App\Models\SecurityAlert::where('employee_id', $user)
                                ->orderBy('logged_at', 'desc')->take(10)->get();
            return view('client.detail', ['data' => $data, 'screenshots' => $screenshots, 'alerts' => $alerts]);
        });

        Route::get('/api/monitor', function (Illuminate\Http\Request $request) {
            $user = $request->query('user');
            $tenantId = tenant('id');
            if ($user) {
                $cacheKey = 'agent_data_' . ($tenantId ? $tenantId . '_' : '') . $user;
                return response()->json(\Illuminate\Support\Facades\Cache::get($cacheKey, []));
            }
            return response()->json([]);
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
        Route::post('employees/{employee}/generate', [\App\Http\Controllers\EmployeeController::class, 'generateToken'])->name('client.employees.generate');

        Route::get('/reports', [\App\Http\Controllers\Client\ReportController::class, 'index'])->name('client.reports.index');
    });
});
