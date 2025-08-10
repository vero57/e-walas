<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presensi;
use App\Models\Walas;
use App\Models\Rombel;
use Faker\Factory as Faker;


class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walas = Walas::with('rombel')->get(); // asumsikan relasi one-to-one walas->rombel

        foreach($walas as $wali) {
             if($wali->rombel){
                 Presensi::create([
                    'walas_id' => $wali->id,
                    'kelas' => $wali->rombel->nama_kelas,
                    'tanggal' => now(),
                ]);
             }
        }
    }
}