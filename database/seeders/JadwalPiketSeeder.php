<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPiket; 
use App\Models\Walas;
use App\Models\Kurikulum;

class JadwalPiketSeeder extends Seeder
{
    public function run(): void
    {
        $walasIds = Walas::pluck('id')->toArray();
        $kurikulum = Kurikulum::first();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        if ($kurikulum) {
            foreach ($walasIds as $walasId) {
                foreach ($days as $day) {
                    JadwalPiket::create([
                        'walas_id' => $walasId,
                        'nama_hari' => $day,
                        'kurikulum_id' => $kurikulum->id,
                        'tanggal' => now(),
                    ]);
                }
            }
        }
    }
}