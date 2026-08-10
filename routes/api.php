<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

// Endpoint API: http://localhost:8000/api/sensor/latest
Route::get('/sensor/latest', [SensorController::class, 'getLatest']);