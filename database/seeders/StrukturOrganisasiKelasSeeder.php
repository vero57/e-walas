<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StrukturOrganisasiKelas; 
use App\Models\Rombel;
use App\Models\Kepsek;
use App\Models\Kurikulum;

class StrukturOrganisasiKelasSeeder extends Seeder
{
    public function run(): void
    {
        $rombels = Rombel::with('walas', 'siswas')->get();
        $kepsek = Kepsek::first();
        $kurikulum = Kurikulum::first();

        if ($rombels->isEmpty() || !$kepsek || !$kurikulum) {
            $this->command->info('Data Rombel/Kepsek/Kurikulum tidak lengkap, lewati StrukturOrganisasiKelasSeeder.');
            return;
        }

        foreach ($rombels as $rombel) {
            $siswas = $rombel->siswas->pluck('id')->toArray();

            // Pastikan ada cukup siswa untuk mengisi semua posisi (minimal 8)
            if (count($siswas) < 8) {
                continue;
            }

            // Acak siswa dan ambil 8 yang unik untuk jabatan
            $pengurusIds = array_rand(array_flip($siswas), 8);

            StrukturOrganisasiKelas::create([
                'walas_id' => $rombel->walas_id,
                'kepala_sekolah' => $kepsek->id,
                'walas' => $rombel->walas_id,
                'ketuakelas' => $pengurusIds[0],
                'waketuakelas' => $pengurusIds[1],
                'bendahara' => $pengurusIds[2],
                'sekretaris' => $pengurusIds[3],
                'seksi_kebersihan' => $pengurusIds[4],
                'seksi_perlengkapan' => $pengurusIds[5],
                'seksi_keamanan' => $pengurusIds[6],
                'seksi_kerohanian' => $pengurusIds[7],
                'kurikulum_id' => $kurikulum->id,
                'tanggal' => now(),
            ]);
        }
    }
}