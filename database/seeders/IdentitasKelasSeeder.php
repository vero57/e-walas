<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IdentitasKelas; 
use App\Models\Rombel;
use App\Models\Walas;

class IdentitasKelasSeeder extends Seeder
{
    public function run(): void
    {
        $rombels = Rombel::with('walas', 'siswas')->get();
        $allWalas = Walas::pluck('id')->toArray();
        
        foreach ($rombels as $rombel) {
            $randomSiswaId = $rombel->siswas->isNotEmpty() ? $rombel->siswas->random()->id : null;

            IdentitasKelas::create([
                'walas_id' => $rombel->walas_id,
                'program_keahlian' => $rombel->kompetensi,
                'kompetensi_keahlian' => $rombel->kompetensi,
                'walas_id_10' => $allWalas[array_rand($allWalas)],
                'walas_id_11' => $allWalas[array_rand($allWalas)],
                'walas_id_12' => $allWalas[array_rand($allWalas)],
                'walas_id_13' => $allWalas[array_rand($allWalas)],
                'siswas_id_10' => $randomSiswaId,
                'siswas_id_11' => $randomSiswaId,
                'siswas_id_12' => $randomSiswaId,
                'siswas_id_13' => $randomSiswaId,
            ]);
        }
    }
}