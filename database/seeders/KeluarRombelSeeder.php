<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeluarRombel; 
use App\Models\Siswa;

class KeluarRombelSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = Siswa::get()->random(5);

        foreach ($siswas as $siswa) {
            KeluarRombel::create([
                'nama_siswa' => $siswa->id,
                'keterangan' => 'pindah_sekolah',
                'rombels_id' => $siswa->rombels_id,
            ]);
        }
    }
}