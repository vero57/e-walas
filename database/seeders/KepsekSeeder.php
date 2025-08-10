<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kepsek;
use Faker\Factory as Faker;

class KepsekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        Kepsek::create([
            'nama' => $faker->name,
            'no_wa' => $faker->numerify('08##########'),
            'password' => Hash::make('kepsek'),
        ]);
    }
}