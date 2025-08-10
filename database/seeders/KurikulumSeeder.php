<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kurikulum;
use Faker\Factory as Faker;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        Kurikulum::create([
            'nama' => $faker->name,
            'no_wa' => $faker->numerify('08##########'),
            'password' => Hash::make('kurikulum'),
            'nip' => $faker->numerify('##################'),
        ]);
    }
}