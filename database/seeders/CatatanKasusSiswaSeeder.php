<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatatanKasusSiswa; 
use App\Models\Siswa;
use Faker\Factory as Faker;

class CatatanKasusSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswas = Siswa::with('rombel.walas')->get()->random(15); 

        foreach($siswas as $siswa) {
            if ($siswa->rombel && $siswa->rombel->walas) {
                CatatanKasusSiswa::create([
                    'walas_id' => $siswa->rombel->walas->id,
                    'siswas_id' => $siswa->id,
                    'kasus' => 'Tidak mengerjakan tugas.',
                    'tindak_lanjut' => 'Diberikan tugas pengganti.',
                    'keterangan' => 'Siswa berjanji akan lebih rajin.',
                ]);
            }
        }
    }
}