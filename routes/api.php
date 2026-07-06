<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/monitor', function (Request $request) {
    $data = $request->all();
    \Illuminate\Support\Facades\Cache::put('agent_data', $data, now()->addMinutes(5));
    
    $broadcastData = $data;
    unset($broadcastData['screen']); // Too large for WebSocket
    
    \App\Events\AgentDataReceived::dispatch($broadcastData);
    return response()->json(['status' => 'ok']);
});

Route::get('/monitor', function () {
    return response()->json(\Illuminate\Support\Facades\Cache::get('agent_data', []));
});
