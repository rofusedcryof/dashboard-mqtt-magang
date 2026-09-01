<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\MillingOeeController; // <- Pindahkan ke baris atas

// Endpoint API: http://localhost:8000/api/sensor/latest
// Route::get('/sensor/latest', [SensorController::class, 'getLatest']);

// Endpoint API: http://localhost:8000/api/dashboard
Route::get('/dashboard', function () {
    $mesin = DB::table('machines')->first();
    
    if (!$mesin) {
        return response()->json(['success' => false, 'message' => 'Data mesin tidak ditemukan']);
    }

    $produksi = DB::table('production_logs')->where('machine_id', $mesin->id)->first();
    $downtimes = DB::table('downtimes')->where('machine_id', $mesin->id)->get();
    $jadwal = DB::table('production_schedules')->get();

    $planned = $downtimes->where('kategori', 'PLANNED')->sum('durasi_menit');
    $unplanned = $downtimes->where('kategori', 'UNPLANNED')->sum('durasi_menit');

    return response()->json([
        'success' => true,
        'data' => [
            'mesin' => $mesin,
            'produksi' => $produksi,
            'downtime' => [
                'planned' => $planned,
                'unplanned' => $unplanned,
                'total' => $planned + $unplanned
            ],
            'jadwal' => $jadwal
        ]
    ]); // <- Tutup kurung untuk response dashboard sampai sini saja
});

// Endpoint API: http://localhost:8000/api/milling-oee
// <- Deklarasikan rute baru di luar rute dashboard
Route::get('/milling-oee', [MillingOeeController::class, 'index']);