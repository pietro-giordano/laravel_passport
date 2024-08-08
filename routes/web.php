<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(ClientController::class)->group(function () {
        Route::get('/clients', 'forUser')->name('admin.clients.index');
        Route::get('/clients/create', 'create')->name('admin.clients.create');
        Route::post('/clients/store', 'store')->name('admin.clients.store');
        Route::delete('/clients/{client_id}', 'destroy')->name('admin.clients.destroy');
    });
});
