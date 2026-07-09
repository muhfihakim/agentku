<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/monitor/{user}', function ($user) {
        $data = \Illuminate\Support\Facades\Cache::get('agent_data_' . $user, [
            'user' => $user,
            'status' => 'offline',
            'window' => 'Unknown',
            'device' => 'Unknown',
            'screen' => ''
        ]);
        return view('detail', ['data' => $data]);
    });
});
