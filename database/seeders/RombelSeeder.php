<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rombel;
use App\Models\Walas;
use Faker\Factory as Faker;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walasIds = Walas::pluck('id')->toArray();

        $tingkat = ['X', 'XI', 'XII'];
        $kompetensi = ['SIJA', 'TKJ', 'RPL', 'DKV', 'DPIB', 'TKP', 'TP','TFLM', 'TKR', 'TOI'];
        $usedWalasIds = [];

        foreach ($tingkat as $t) {
            foreach ($kompetensi as $k) {
                if (empty(array_diff($walasIds, $usedWalasIds))) break 2;


                $availableWalasIds = array_diff($walasIds, $usedWalasIds);
                $walasId = $faker->randomElement($availableWalasIds);
                $usedWalasIds[] = $walasId;

                Rombel::create([
                    'tingkat' => $t,
                    'kompetensi' => $k,
                    'nama_kelas' => $t . ' ' . $k . ' ' . $faker->numberBetween(1, 2),
                    'walas_id' => $walasId,
                ]);
            }
        }
    }
}