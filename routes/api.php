<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('info');
});

Route::get('/activity', [ActivityController::class, 'index']);

Route::post('/activity', [ActivityController::class, 'index']);


