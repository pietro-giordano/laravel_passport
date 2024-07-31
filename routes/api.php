<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('user');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
