<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Walas;
use Faker\Factory as Faker;

class WalasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 15; $i++) {
            Walas::create([
                'nama' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Perempuan', 'Laki-laki']),
                'no_wa' => $faker->numerify('08##########'),
                'password' => Hash::make('walas'),
                'nip' => $faker->numerify('##################'),
            ]);
        }
    }
}