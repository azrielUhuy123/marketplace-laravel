<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

Route::prefix('store')->group(function () {
    Route::get('/create', [StoreController::class, 'create']);
    Route::post('/', [StoreController::class, 'store']);
});