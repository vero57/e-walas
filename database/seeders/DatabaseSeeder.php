<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            GuruSeeder::class,
            KepsekSeeder::class,
            KurikulumSeeder::class,
            KakomSeeder::class,
            WalasSeeder::class,
            RombelSeeder::class,

            MapelSeeder::class,
            DaftarSerahTerimaRaporSeeder::class,
            LembarPengesahanSeeder::class,
            RekapitulasiJumlahSiswaSeeder::class,
            AgendaKegiatanWalasSeeder::class,
            RencanaKegiatanWalasSeeder::class,
            RencanaKegiatanWalasGenapSeeder::class,
            PresensiSeeder::class,
            PersentaseSosialEkonomiSeeder::class,
            JadwalKbmSeeder::class,

            SiswaSeeder::class,
            HomeVisitSeeder::class,
            BukuTamuOrangtuaSeeder::class,
            CatatanKasusSiswaSeeder::class,
            DetailPresensiSeeder::class,
            JadwalPiketSeeder::class,
            DetailJadwalPiketSeeder::class,
            DenahTempatKerjaKelompokSeeder::class,
            KelompokSiswaSeeder::class,
            StrukturOrganisasiKelasSeeder::class,

            BiodataSiswaSeeder::class,
            DaftarPesertaDidikSeeder::class,
            PrestasiSiswaSeeder::class,
            BeritaAcaraSerahTerimaSeeder::class,
            BeritaAcaraKenaikanSeeder::class,
            BeritaAcaraKelulusanSeeder::class,
            KeluarRombelSeeder::class,
            AlumniSeeder::class,
            IdentitasKelasSeeder::class,
        ]);
    }
}