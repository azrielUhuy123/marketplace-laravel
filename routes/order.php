<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/{id}/process', [OrderController::class, 'process']);
    Route::post('/{id}/ship', [OrderController::class, 'ship']);
    Route::post('/{id}/deliver', [OrderController::class, 'deliver']);
});