<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api/v1')
    ->middleware('apikey')
    ->group(function () {

        // Collection
        Route::get(
            '/guest-sessions',
            [GuestSessionController::class, 'index']
        );

        // Resource
        Route::get(
            '/guest-sessions/{id}',
            [GuestSessionController::class, 'show']
        );

        // Action
        Route::post(
            '/guest-sessions',
            [GuestSessionController::class, 'store']
        );

        // Update
        Route::put(
            '/guest-sessions/{id}',
            [GuestSessionController::class, 'update']
        );
    });