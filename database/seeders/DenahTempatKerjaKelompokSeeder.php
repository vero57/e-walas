<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DenahTempatKerjaKelompok; 
use App\Models\Walas;
use Faker\Factory as Faker;

class DenahTempatKerjaKelompokSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walasIds = Walas::pluck('id')->toArray();

        foreach ($walasIds as $walasId) {
            for ($i = 1; $i <= 6; $i++) { 
                DenahTempatKerjaKelompok::create([
                    'walas_id' => $walasId,
                    'nama_kelompok' => 'Kelompok ' . $faker->word,
                ]);
            }
        }
    }
}