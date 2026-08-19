<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Models\Service;

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

//explore services
Route::get('/services', [ServiceController::class, 'webIndex']);
//detail jasa
Route::get('/services/{id}', [ServiceController::class, 'webShow']);
//order jasa
Route::get('/services/{id}/order', [OrderController::class, 'webCreate']);