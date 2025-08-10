<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrestasiSiswa; 
use App\Models\Siswa;
use Faker\Factory as Faker;

class PrestasiSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswas = Siswa::with('rombel.walas')->get()->random(20);

        foreach ($siswas as $siswa) {
            if ($siswa->rombel && $siswa->rombel->walas) {
                PrestasiSiswa::create([
                    'walas_id' => $siswa->rombel->walas->id,
                    'siswas_id' => $siswa->id,
                    'rombels_id' => $siswa->rombels_id,
                    'jenis_prestasi' => $faker->randomElement(['Akademik', 'Non-akademik']),
                    'nama_prestasi' => 'Juara ' . $faker->numberBetween(1, 3) . ' Lomba Cerdas Cermat',
                    'tanggal' => now(),
                ]);
            }
        }
    }
}