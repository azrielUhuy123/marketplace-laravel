<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add/{id}', [CartController::class, 'add']);
    Route::delete('/remove/{id}', [CartController::class, 'remove']);
});