<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {

    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    return view('home');
});

Route::get('/login', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'webLogin']);