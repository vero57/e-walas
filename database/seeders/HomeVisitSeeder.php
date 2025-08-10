<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeVisit; 
use App\Models\Siswa;
use Faker\Factory as Faker;

class HomeVisitSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswas = Siswa::with('rombel.walas')->get()->random(10); 

        foreach($siswas as $siswa) {
            if ($siswa->rombel && $siswa->rombel->walas) {
                HomeVisit::create([
                    'walas_id' => $siswa->rombel->walas->id,
                    'tanggal' => now(),
                    'nama_peserta_didik' => $siswa->nama,
                    'tindak_lanjut' => 'Diberikan bimbingan dan motivasi.',
                    'kasus' => 'Sering datang terlambat.',
                    'solusi' => 'Orang tua akan lebih memperhatikan jam berangkat.',
                    'bukti_url' => $faker->imageUrl(640, 480, 'people', true),
                    'dokumentasi_url' => $faker->imageUrl(640, 480, 'house', true),
                ]);
            }
        }
    }
}