<?php

namespace App\Http\Controllers;

use App\Models\MillingOee;
use Illuminate\Http\Request;

class MillingOeeController extends Controller
{
    public function index()
    {
        $data = MillingOee::orderBy('hari', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'summary' => [
                'avg_availability' => round($data->avg('availability'), 2),
                'avg_performance' => round($data->avg('performance'), 2),
                'avg_quality' => round($data->avg('quality_rate'), 2),
                'avg_oee' => round($data->avg('oee'), 2),
            ],
            'data' => $data
        ]);
    }
}