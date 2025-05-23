<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\OrderController;



Route::get('/test-api', function(){
    return response()->json([
        "status" => "success"
    ]);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // Jika Anda ingin fitur registrasi
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/order',[OrderController::class,'index']);
    Route::post('/order',[OrderController::class,'store']);
    Route::get('/order/{id}/show',[OrderController::class,'show']);
    Route::put('/order/{id}/update',[OrderController::class,'update']);
    Route::delete('/order/{id}/delete',[OrderController::class,'destory']);
    // Route API lainnya yang memerlukan otentikasi
});
