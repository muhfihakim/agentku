<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'apiLogin']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/monitor', function (Request $request) {
    $data = $request->all();
    $token = $request->header('Authorization') ? str_replace('Bearer ', '', $request->header('Authorization')) : ($data['token'] ?? null);
    $tenantId = $request->header('X-Tenant') ?? ($data['tenant'] ?? null);
    
    if ($token && $tenantId) {
        $tenant = \App\Models\Tenant::find($tenantId);
        if ($tenant) {
            tenancy()->initialize($tenant);
            $employee = \App\Models\Employee::where('device_token', $token)->first();
            if ($employee) {
                $employee->update([
                    'os_info' => $data['os'] ?? $employee->os_info,
                    'device_info' => $data['device'] ?? $employee->device_info,
                    'status' => 'online',
                    'last_active_at' => now(),
                ]);
                // update user string based on employee
                $data['user'] = $employee->id;
            }
            tenancy()->end();
        }
    }
    
    $userKey = $data['user'] ?? 'unknown';
    \Illuminate\Support\Facades\Cache::put('agent_data_' . $userKey, $data, now()->addMinutes(5));
    
    $broadcastData = $data;
    unset($broadcastData['screen']); // Too large for WebSocket
    
    \App\Events\AgentDataReceived::dispatch($broadcastData);
    return response()->json(['status' => 'ok']);
});

Route::get('/monitor', function (Request $request) {
    $user = $request->query('user');
    if ($user) {
        return response()->json(\Illuminate\Support\Facades\Cache::get('agent_data_' . $user, []));
    }
    return response()->json(\Illuminate\Support\Facades\Cache::get('agent_data', []));
});
