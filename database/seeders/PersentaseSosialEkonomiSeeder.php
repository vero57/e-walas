<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersentaseSosialEkonomi; 
use App\Models\Walas;
use Faker\Factory as Faker;

class PersentaseSosialEkonomiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walasIds = Walas::pluck('id')->toArray();
        $jenis = ['Orang Tua PNS', 'Orang Tua Wiraswasta', 'Penerima KIP', 'Yatim/Piatu'];

        foreach ($walasIds as $walasId) {
             foreach ($jenis as $j) {
                PersentaseSosialEkonomi::create([
                    'walas_id' => $walasId,
                    'jenis_sosial_ekonomi' => $j,
                    'jumlah' => $faker->numberBetween(5, 10),
                    'persentase' => $faker->numberBetween(10, 30) . '%',
                    'keterangan' => $faker->sentence(3),
                    'tanggal' => now(),
                ]);
            }
        }
    }
}