<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPresensi; 
use App\Models\Presensi;
use App\Models\Siswa;
use Faker\Factory as Faker;

class DetailPresensiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $presensiRecords = Presensi::with('walas.rombel.siswas')->get();

        if ($presensiRecords->isEmpty()) {
            $this->command->info('Tidak ada data Presensi, lewati DetailPresensiSeeder.');
            return;
        }

        foreach ($presensiRecords as $presensi) {
            // Ambil siswa dari rombel yang diajar oleh walas pada record presensi
            if ($presensi->walas && $presensi->walas->rombel) {
                $siswas = $presensi->walas->rombel->siswas;
                foreach ($siswas as $siswa) {
                    DetailPresensi::create([
                        'presensis_id' => $presensi->id,
                        'siswas_id' => $siswa->id,
                        'status' => $faker->randomElement(['hadir', 'sakit', 'izin', 'alfa']),
                    ]);
                }
            }
        }
    }
}