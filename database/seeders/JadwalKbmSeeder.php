<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKbm;
use App\Models\Rombel;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kurikulum;
use Faker\Factory as Faker;

class JadwalKbmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $rombels = Rombel::with('walas')->get();
        $guruIds = Guru::pluck('id')->toArray();
        $mapelIds = Mapel::pluck('id')->toArray();
        $kurikulum = Kurikulum::first();

        if ($rombels->isEmpty() || empty($guruIds) || empty($mapelIds) || !$kurikulum) {
            $this->command->info('Tidak dapat membuat jadwal, pastikan data Rombel, Guru, Mapel, dan Kurikulum sudah ada.');
            return;
        }

        foreach ($rombels as $rombel) {
            $jadwalHarian = [];
            $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

            foreach ($days as $day) {
                $jadwalJam = [];
                // Membuat jadwal untuk 10 jam pelajaran
                for ($jam = 1; $jam <= 10; $jam++) {
                    $jadwalJam[$jam] = [
                        'mapel_id' => $faker->randomElement($mapelIds),
                        'guru_id' => $faker->randomElement($guruIds),
                    ];
                }
                $jadwalHarian[$day] = json_encode($jadwalJam);
            }

            JadwalKbm::create(array_merge([
                'rombels_id' => $rombel->id,
                'walas_id' => $rombel->walas_id,
                'kurikulum_id' => $kurikulum->id,
                'tanggal' => $faker->dateTimeThisYear(),
            ], $jadwalHarian));
        }
    }
}