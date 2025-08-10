<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BeritaAcaraKelulusan; 
use App\Models\Rombel;
use Faker\Factory as Faker;

class BeritaAcaraKelulusanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // Hanya untuk rombel tingkat XII dan XIII
        $rombels = Rombel::with('siswas')->whereIn('tingkat', ['XII', 'XIII'])->get();

        foreach ($rombels as $rombel) {
            $laki = $rombel->siswas->where('jenis_kelamin', 'Laki-laki')->count();
            $perempuan = $rombel->siswas->where('jenis_kelamin', 'Perempuan')->count();

            BeritaAcaraKelulusan::create([
                'walas_id' => $rombel->walas_id,
                'waktu_tanggal' => now(),
                'tempat' => 'Ruang Aula',
                'jumlah_peserta_rapat' => 30,
                'rombels_id' => $rombel->id,
                'laki_laki_lulus' => $laki,
                'perempuan_lulus' => $perempuan,
                'laki_laki_tidaklulus' => 0,
                'perempuan_tidaklulus' => 0,
            ]);
        }
    }
}