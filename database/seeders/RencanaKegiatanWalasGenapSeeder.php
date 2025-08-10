<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RencanaKegiatanWalasGenap;
use App\Models\Walas;
use App\Models\Kurikulum;
use Faker\Factory as Faker;

class RencanaKegiatanWalasGenapSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $walasIds = Walas::pluck('id')->toArray();
        $kurikulum = Kurikulum::first();

        $kegiatan = [
            'Menyusun program / mengisi adm wali kelas - Adm Wali kelas',
            'Menyusun struktur organisasi kelas - Organigram',
            'Sosialisasi sistem pemelajaran Kurikulum 2013 atau Kurikulum Merdeka - Absensi',
            'Menata tempat duduk di kelas - Denah kelas',
            'Membagi biodata peserta didik - Ada bio data',
            'Mengisi data peserta - Ada data peserta',
            'Membimbing peserta didik - Ada daftar bimbingan',
            'Mengecek kehadiran peserta didik - Ada rekap',
            'Menindaklanjuti hasil pengecekan absensi - Pemang. / homevisit',
            'Membenahi keadaan kelas - Kelas tertata / lengkap',
            'Mengontrol kemajuan hasil pemelajaran - Rekaman kegiatan',
            'Visit Class - Surat tugas',
            'Home Visit - Rekaman kegiatan',
            'Rekapitulasi nilai kompetensi - Rekap nilai',
            'Membimbing remedial peserta didik - Daftar Remedial',
            'Mengisi Leger - Ada Leger',
            'Mengisi Buku Laporan - Ada buku Laporan',
            'Membagi dokumen hasil pembelajaran - Daftar serah terima raport'
        ];

        foreach ($walasIds as $walasId) {
            foreach ($kegiatan as $kg) {
                RencanaKegiatanWalasGenap::create([
                    'walas_id' => $walasId,
                    'minggu_ke' => $faker->numberBetween(1, 18),
                    'kegiatan_bukti' => $kg,
                    'keterangan' => $faker->randomElement(['true', 'false']),
                    'kurikulum_id' => $kurikulum->id,
                ]);
            }
        }
    }
}