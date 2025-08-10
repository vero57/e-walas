<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa; 
use App\Models\Rombel;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $rombels = Rombel::all();

        if ($rombels->isEmpty()) {
            $this->command->info('Tidak ada data Rombel, lewati SiswaSeeder.');
            return;
        }

        foreach ($rombels as $rombel) {
            for ($i = 0; $i < 30; $i++) { 
                Siswa::create([
                    'nama' => $faker->name,
                    'rombels_id' => $rombel->id,
                    'jenis_kelamin' => $faker->randomElement(['Perempuan', 'Laki-laki']),
                    'no_wa' => $faker->numerify('08##########'),
                    'password' => Hash::make('siswa'),
                    'status' => 'aktif',
                ]);
            }
        }
    }
}