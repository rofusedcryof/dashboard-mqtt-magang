<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Dummy Mesin
        $machineId = DB::table('machines')->insertGetId([
            'nama_mesin' => 'Station 1 - Assembly',
            'status' => 'RUNNING',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Dummy Produksi
        DB::table('production_logs')->insert([
            'machine_id' => $machineId,
            'gross_production' => 12450,
            'waste' => 45,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Dummy Downtime
        DB::table('downtimes')->insert([
            ['machine_id' => $machineId, 'kategori' => 'PLANNED', 'durasi_menit' => 413, 'alasan' => 'Istirahat & Maintenance Rutin', 'created_at' => $now, 'updated_at' => $now],
            ['machine_id' => $machineId, 'kategori' => 'UNPLANNED', 'durasi_menit' => 63, 'alasan' => 'Mati Lampu', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4. Dummy Jadwal Produksi (Persis seperti video)
        DB::table('production_schedules')->insert([
            ['prioritas' => 1, 'kode_produk' => 'PRD-2026-X1', 'target_qty' => 5600, 'status' => 'IN_PROGRESS', 'created_at' => $now, 'updated_at' => $now],
            ['prioritas' => 2, 'kode_produk' => 'PRD-2026-X2', 'target_qty' => 2000, 'status' => 'MENUNGGU', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}