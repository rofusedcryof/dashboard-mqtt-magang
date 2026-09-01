<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MillingOeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('milling_oees')->truncate();

        $now = Carbon::now();
        
        $csvFile = fopen(base_path("database/seeders/mesin-miling-OEE-Downtime.csv"), "r");

        $firstline = true;
        $insertData = [];
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $insertData[] = [
                    'hari'               => (int)$data[0],
                    'setup_time_mnt'     => (int)$data[1],
                    'operating_time_mnt' => (int)$data[2],
                    'produk_liter'       => (int)$data[3],
                    'downtime_jam'       => (int)$data[4],
                    'keterangan'         => $data[5] === '' ? null : $data[5],
                    
                    //remove simbol '%' trs ubah jadi tipe float/desimal
                    'availability'       => (float)str_replace('%', '', $data[6]),
                    'performance'        => (float)str_replace('%', '', $data[7]),
                    'quality_rate'       => (float)str_replace('%', '', $data[8]),
                    'oee'                => (float)str_replace('%', '', $data[9]),
                    
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ];
            }
            $firstline = false;
        }

        fclose($csvFile);

        DB::table('milling_oees')->insert($insertData);
    }
}