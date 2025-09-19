<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('HomePage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/register', [UserController::class, 'register']);
