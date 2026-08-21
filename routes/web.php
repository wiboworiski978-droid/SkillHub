<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

// Home
Route::get('/', [HomeController::class, 'index']);

// Login
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'webLogin']);

// Logout
Route::post('/logout', [AuthController::class, 'webLogout']);

// Explore Services
Route::get('/services', [ServiceController::class, 'webIndex']);

//pemilik jasa harus bisa  melihat siapa yang order jasanya
Route::get('/orders/incoming', [OrderController::class, 'webIncoming']);

//detail order masuk
Route::get('/orders/incoming/{id}', [OrderController::class, 'webIncomingShow']);

//terima /tolak order
Route::post(
    '/orders/incoming/{id}/status',
    [OrderController::class, 'webUpdateStatus']
);

//mulai pengerjaan
Route::post('/orders/incoming/{id}/start', [OrderController::class, 'webStartOrder']);

//selesaikan order
Route::post('/orders/incoming/{id}/complete', [OrderController::class, 'webCompleteOrder']);

// Detail Jasa
Route::get('/services/{id}', [ServiceController::class, 'webShow']);

// Order Jasa
Route::get('/services/{id}/order', [OrderController::class, 'webCreate']);
Route::post('/services/{id}/order', [OrderController::class, 'webStore']);

// Order Saya
Route::get('/orders', [OrderController::class, 'webIndex']);

// Detail Order
Route::get('/orders/{id}', [OrderController::class, 'webShow']);

// Cancel Order
Route::post('/orders/{id}/cancel', [OrderController::class, 'webCancel']);

//profil
Route::get('/profile', [ProfileController::class, 'webShow']);

