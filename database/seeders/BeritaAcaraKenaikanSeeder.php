<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BeritaAcaraKenaikan;
use App\Models\Rombel;
use Faker\Factory as Faker;

class BeritaAcaraKenaikanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // Hanya untuk rombel tingkat X dan XI
        $rombels = Rombel::with('siswas')->whereIn('tingkat', ['X', 'XI'])->get();

        foreach ($rombels as $rombel) {
            $laki = $rombel->siswas->where('jenis_kelamin', 'Laki-laki')->count();
            $perempuan = $rombel->siswas->where('jenis_kelamin', 'Perempuan')->count();

            BeritaAcaraKenaikan::create([
                'walas_id' => $rombel->walas_id,
                'waktu_tanggal' => now(),
                'hari' => 'Sabtu',
                'jam' => '10:00',
                'tempat' => 'Ruang Rapat',
                'jumlah_peserta_rapat' => 25,
                'rombels_id' => $rombel->id,
                'kelas_baru' => ($rombel->tingkat == 'X' ? 'XI' : 'XII') . ' ' . $rombel->kompetensi,
                'laki_laki_naik' => $laki,
                'perempuan_naik' => $perempuan,
                'laki_laki_tinggal' => 0,
                'perempuan_tinggal' => 0,
            ]);
        }
    }
}