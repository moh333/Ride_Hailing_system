<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PassengerController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\TripController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('trips')->group(function () {
    Route::post('request', [TripController::class, 'request']);
});

Route::prefix('passengers')->group(function () {
    Route::post('register', [PassengerController::class, 'register']);
});

Route::prefix('drivers')->group(function () {
    Route::post('register', [DriverController::class, 'register']);
});
