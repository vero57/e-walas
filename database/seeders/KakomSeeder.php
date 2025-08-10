<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kakom;
use Faker\Factory as Faker;

class KakomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kompetensi = ['SIJA', 'TKJ', 'RPL', 'DKV', 'DPIB', 'TKP', 'TP','TFLM', 'TKR', 'TOI'];

        foreach ($kompetensi as $jurusan) {
            Kakom::create([
                'nama' => $faker->name,
                'no_wa' => $faker->numerify('08##########'),
                'password' => Hash::make('kakom'),
                'kompetensi' => $jurusan,
            ]);
        }
    }
}