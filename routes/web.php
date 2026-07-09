<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner', [TenantController::class, 'index'])->name('owner.dashboard');
    Route::post('/owner/tenants', [TenantController::class, 'store'])->name('owner.tenants.store');
    Route::delete('/owner/tenants/{id}', [TenantController::class, 'destroy'])->name('owner.tenants.destroy');

    Route::get('/owner/billing', function() {
        return view('owner.billing');
    })->name('owner.billing');

    Route::get('/owner/settings', function() {
        return view('owner.settings');
    })->name('owner.settings');
});

Route::middleware(['auth', 'tenant.auth'])->group(function () {
    Route::get('/', function () {
        return view('client.dashboard');
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
});
