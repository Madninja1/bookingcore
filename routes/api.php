<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\GuideController;
use Illuminate\Support\Facades\Route;


Route::prefix('guides')->group(function () {
    Route::get('/', [GuideController::class, 'index']);
});

Route::post('bookings', [BookingController::class, 'store']);
