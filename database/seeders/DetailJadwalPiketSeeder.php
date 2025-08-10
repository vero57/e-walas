<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailJadwalPiket;
use App\Models\JadwalPiket;
use App\Models\Siswa;

class DetailJadwalPiketSeeder extends Seeder
{
    public function run(): void
    {
        $jadwalPikets = JadwalPiket::with('walas.rombel.siswas')->get();

        foreach($jadwalPikets as $jadwal) {
            if($jadwal->walas && $jadwal->walas->rombel) {
                $siswas = $jadwal->walas->rombel->siswas;
                if ($siswas->count() >= 5) {
                    // Ambil 5 siswa acak untuk piket hari itu
                    $siswaPiket = $siswas->random(5);
                    foreach($siswaPiket as $siswa) {
                        DetailJadwalPiket::create([
                            'jadwalpikets_id' => $jadwal->id,
                            'siswas_id' => $siswa->id,
                        ]);
                    }
                }
            }
        }
    }
}