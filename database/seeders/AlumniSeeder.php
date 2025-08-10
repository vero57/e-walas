<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumni; 
use App\Models\Siswa;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil siswa dari rombel tingkat akhir
        $lulusan = Siswa::whereHas('rombel', function ($query) {
            $query->whereIn('tingkat', ['XII', 'XIII']);
        })->get();

        foreach ($lulusan as $siswa) {
            Alumni::create([
                'siswa_id' => $siswa->id,
                'nama' => $siswa->nama,
                'no_wa' => $siswa->no_wa,
                'rombels_id' => $siswa->rombels_id,
            ]);
        }
    }
}