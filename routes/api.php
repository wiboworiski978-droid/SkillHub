<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;

//test api relation
use App\Models\User;
use App\Models\Category;

Route::middleware('auth:sanctum')->get('/test-relations', function () {
    return response()->json([
        'user_services' => User::with('services')->first(),
        'category_services' => Category::with('services')->first(),
    ]);
});

//auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',[AuthController::class, 'logout']);

    //show and update
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']); 
});

//middleware admin
Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'Anda berhasil masuk sebagai admin'
    ]);
});

//semua user yang login boleh melihat kategori
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    //Khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });

    //jasa
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    //status=active or inactive
    Route::patch('/services/{id}/toggle-status', [ServiceController::class, 'toggleStatus']);

    //order
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    Route::put('/orders/{id}/start', [OrderController::class, 'startOrder']);
    Route::put('/orders/{id}/complete', [OrderController::class, 'completeOrder']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
    });

