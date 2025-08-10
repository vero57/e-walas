<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelompokSiswa; 
use App\Models\DenahTempatKerjaKelompok;
use App\Models\Siswa;

class KelompokSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelompokRecords = DenahTempatKerjaKelompok::with('walas.rombel.siswas')->get();

        foreach ($kelompokRecords as $kelompok) {
             if($kelompok->walas && $kelompok->walas->rombel) {
                $siswas = $kelompok->walas->rombel->siswas;
                // Ambil 5 siswa acak untuk kelompok ini
                if ($siswas->count() >= 5) {
                    $anggota = $siswas->random(5);
                     foreach ($anggota as $siswa) {
                        KelompokSiswa::firstOrCreate(
                            ['siswa_id' => $siswa->id], // Mencegah siswa masuk ke banyak kelompok
                            ['kelompok_id' => $kelompok->id]
                        );
                    }
                }
             }
        }
    }
}