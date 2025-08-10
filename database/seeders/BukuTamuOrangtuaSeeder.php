<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BukuTamuOrangtua;
use App\Models\Siswa;
use Faker\Factory as Faker;

class BukuTamuOrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswas = Siswa::with('rombel.walas')->get()->random(10); // Ambil 10 siswa acak

        foreach($siswas as $siswa) {
             if ($siswa->rombel && $siswa->rombel->walas) {
                BukuTamuOrangtua::create([
                    'walas_id' => $siswa->rombel->walas->id,
                    'tanggal' => now(),
                    'nama_peserta_didik' => $siswa->nama,
                    'nama_orang_tua' => $faker->name('male'),
                    'tindak_lanjut' => 'Diskusi perkembangan akademik.',
                    'kasus' => 'Nilai menurun pada beberapa mata pelajaran.',
                    'solusi' => 'Akan diadakan jam belajar tambahan di rumah.',
                    'dokumentasi_url' => $faker->imageUrl(640, 480, 'meeting', true),
                ]);
            }
        }
    }
}