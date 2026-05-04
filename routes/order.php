<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::middleware(['auth'])->group(function () {

    Route::get('/order', [OrderController::class, 'index']);

});

Route::middleware(['auth', 'role:seller'])->group(function () {

    Route::post('/order/{id}/process', [OrderController::class, 'process']);

});

Route::middleware(['auth', 'role:logistic'])->group(function () {

    Route::post('/order/{id}/ship', [OrderController::class, 'ship']);

});

Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::post('/order/{id}/deliver', [OrderController::class, 'deliver']);

});