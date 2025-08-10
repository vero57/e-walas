<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekapitulasiJumlahSiswa;
use App\Models\Walas;
use App\Models\Kurikulum;
use Faker\Factory as Faker;

class RekapitulasiJumlahSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walasIds = Walas::pluck('id')->toArray();
        $kurikulum = Kurikulum::first();

        if($kurikulum) {
            foreach($walasIds as $walasId) {
                RekapitulasiJumlahSiswa::create([
                    'walas_id' => $walasId,
                    'bulan' => 'Juli',
                    'jumlah_awal_siswa' => 36,
                    'jumlah_akhir_siswa' => 36,
                    'keterangan' => 'Tidak ada perubahan',
                    'kurikulum_id' => $kurikulum->id,
                    'tanggal' => now(),
                ]);
            }
        }
    }
}