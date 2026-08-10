<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 'Aktif',
        'message' => 'Laravel Backend API berjalan normal.'
    ]);
});