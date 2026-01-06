<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\TripController;

Route::post('/trips/request', [TripController::class, 'request']);

use App\Http\Controllers\Api\PassengerController;
use App\Http\Controllers\Api\DriverController;

Route::post('/passengers/register', [PassengerController::class, 'register']);
Route::post('/drivers/register', [DriverController::class, 'register']);
