<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DaftarSerahTerimaRapor; 
use App\Models\Walas;
use Faker\Factory as Faker;

class DaftarSerahTerimaRaporSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $walasIds = Walas::pluck('id')->toArray();

        foreach($walasIds as $walasId) {
            DaftarSerahTerimaRapor::create([
                'walas_id' => $walasId,
                'image_url' => $faker->imageUrl(640, 480, 'document', true),
            ]);
        }
    }
}