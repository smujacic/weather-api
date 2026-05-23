<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', function(Request $request) {
    return response()->json(['ok' => 'jes sve je ok']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class,  'logout']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('cities', CityController::class);
    Route::get('/weather/search', [WeatherController::class, 'search']);
    Route::apiResource('weather', WeatherController::class)->only(['index']);
});