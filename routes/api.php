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
            if (!$employee) {
                tenancy()->end();
                return response()->json(['status' => 'error', 'message' => 'Token revoked or invalid'], 401);
            }
            if ($employee) {
                $employee->update([
                    'os_info' => $data['os'] ?? $employee->os_info,
                    'device_info' => $data['device'] ?? $employee->device_info,
                    'status' => 'online',
                    'last_active_at' => now(),
                ]);
                
                if (isset($data['screen']) && $data['screen']) {
                    $lastScreenshot = \App\Models\EmployeeScreenshot::where('employee_id', $employee->id)
                        ->orderBy('captured_at', 'desc')->first();
                    if (!$lastScreenshot || $lastScreenshot->captured_at->diffInMinutes(now()) >= 5) {
                        $imgData = explode(',', $data['screen']);
                        if (count($imgData) > 1) {
                            $img = base64_decode($imgData[1]);
                            $filename = 'screenshots/' . $employee->id . '_' . time() . '.jpg';
                            \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $img);
                            \App\Models\EmployeeScreenshot::create([
                                'employee_id' => $employee->id,
                                'file_path' => $filename,
                                'active_window' => $data['window'] ?? null,
                                'captured_at' => now(),
                            ]);
                        }
                    }
                }

                if (isset($data['usb_drives']) && is_array($data['usb_drives'])) {
                    $cacheKeyUsb = 'employee_usb_' . $employee->id;
                    $lastUsbDrives = \Illuminate\Support\Facades\Cache::get($cacheKeyUsb);
                    if ($lastUsbDrives === null) {
                        \Illuminate\Support\Facades\Cache::put($cacheKeyUsb, $data['usb_drives'], now()->addDays(1));
                    } else {
                        $currentUsbDrives = $data['usb_drives'];
                        $newDrives = array_diff($currentUsbDrives, $lastUsbDrives);
                        $removedDrives = array_diff($lastUsbDrives, $currentUsbDrives);
                        
                        foreach ($newDrives as $drive) {
                            \App\Models\SecurityAlert::create([
                                'employee_id' => $employee->id,
                                'type' => 'usb_inserted',
                                'description' => "USB Drive Inserted: {$drive}",
                                'device_details' => ['drive' => $drive],
                                'logged_at' => now(),
                            ]);
                        }
                        foreach ($removedDrives as $drive) {
                            \App\Models\SecurityAlert::create([
                                'employee_id' => $employee->id,
                                'type' => 'usb_removed',
                                'description' => "USB Drive Removed: {$drive}",
                                'device_details' => ['drive' => $drive],
                                'logged_at' => now(),
                            ]);
                        }
                        if (!empty($newDrives) || !empty($removedDrives)) {
                            \Illuminate\Support\Facades\Cache::put($cacheKeyUsb, $currentUsbDrives, now()->addDays(1));
                        }
                    }
                }

                $data['user'] = $employee->id;
            }
            tenancy()->end();
        }
    }
    
    $userKey = $data['user'] ?? 'unknown';
    $cacheKey = 'agent_data_' . ($tenantId ? $tenantId . '_' : '') . $userKey;
    \Illuminate\Support\Facades\Cache::put($cacheKey, $data, now()->addMinutes(5));
    
    $broadcastData = $data;
    unset($broadcastData['screen']); // Too large for WebSocket
    
    \App\Events\AgentDataReceived::dispatch($broadcastData);
    return response()->json(['status' => 'ok']);
});
