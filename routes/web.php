<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {

    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    return view('home');
});
//login
Route::get('/login', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'webLogin']);

//logout
Route::post('/logout', [AuthController::class, 'webLogout']);