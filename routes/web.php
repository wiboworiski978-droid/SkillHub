<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;

// Home
Route::get('/', [HomeController::class, 'index']);

// Login
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'webLogin']);

//Register
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'webRegister']);
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

//riwayat order
Route::get('/orders/history', [OrderController::class, 'webHistory']);

//jasa saya
Route::get('/my-services', [ServiceController::class, 'myService']);

//buat jasa
Route::get('/services/create', [ServiceController::class, 'webCreate']);
Route::post('services', [ServiceController::class, 'webStore']);

//edit jasa
Route::get('/services/{id}/edit', [ServiceController::class, 'webEdit']);
Route::put('/services/{id}', [ServiceController::class, 'webUpdate']);

//hapus jasa
Route::delete('services/{id}', [ServiceController::class, 'webDestroy']);
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

//edit profile
Route::get('/profile/edit', [ProfileController::class, 'webEdit']);

//update profile
Route::put('/profile/edit', [ProfileController::class, 'webUpdate']);

// CRUD kategori hanya admin
Route::get('/categories', [CategoryController::class, 'webIndex']);

Route::get('/categories/create', [CategoryController::class, 'webCreate']);

Route::post('/categories', [CategoryController::class, 'webStore']);

Route::get('/categories/{id}/edit', [CategoryController::class, 'webEdit']);

Route::put('/categories/{id}', [CategoryController::class, 'webUpdate']);

Route::delete('/categories/{id}', [CategoryController::class, 'webDestroy']);

//dashboar admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware('role:admin');

//admin - kelola user
Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware('role:admin');
Route::delete('/admin/users/{id}/delete', [AdminUserController::class, 'destroy'])
    ->middleware('role:admin');