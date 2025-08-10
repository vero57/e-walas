<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgendaKegiatanWalas; 
use App\Models\Walas;
use Faker\Factory as Faker;

class AgendaKegiatanWalasSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walasIds = Walas::pluck('id')->toArray();

        foreach($walasIds as $walasId) {
            for ($i=0; $i<3; $i++) {
                AgendaKegiatanWalas::create([
                    'walas_id' => $walasId,
                    'hari' => $faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']),
                    'tanggal' => $faker->dateTimeThisMonth(),
                    'nama_kegiatan' => 'Rapat Koordinasi dengan Orang Tua Murid',
                    'hasil' => 'Tercapai kesepakatan bersama.',
                    'waktu' => $faker->time('H:i:s'),
                    'tanggalttd' => now()
                ]);
            }
        }
    }
}