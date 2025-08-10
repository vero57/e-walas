<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel; 

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapels = [
            'Pendidikan Agama dan Budi Pekerti',
            'Pendidikan Pancasila',
            'Bahasa Indonesia',
            'Matematika',
            'Sejarah Indonesia',
            'Bahasa Inggris',
            'Seni Budaya',
            'Pendidikan Jasmani, Olahraga, dan Kesehatan',
            'Dasar-dasar Kejuruan RPL',
            'Dasar-dasar Kejuruan SIJA',
            'Pemrograman Web',
            'Basis Data',
            'Infrastruktur Jaringan',
        ];

        foreach ($mapels as $mapel) {
            Mapel::create(['nama_mapel' => $mapel]);
        }
    }
}