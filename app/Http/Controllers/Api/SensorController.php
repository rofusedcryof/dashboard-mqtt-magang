<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function getLatest()
    {
        // Mengambil 10 data suhu terakhir dari MySQL
        $data = SensorLog::orderBy('created_at', 'desc')->take(10)->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data sensor berhasil diambil',
            'data'    => $data
        ]);
    }
}