<?php

use Illuminate\Support\Facades\Route;

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
