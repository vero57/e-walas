<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DaftarPesertaDidik; 
use App\Models\BiodataSiswa;
use App\Models\Kurikulum;

class DaftarPesertaDidikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $biodataSiswa = BiodataSiswa::all();
        $kurikulum = Kurikulum::first();

        if ($biodataSiswa->isEmpty() || !$kurikulum) {
            $this->command->info('Data Biodata Siswa atau Kurikulum tidak ada, lewati DaftarPesertaDidikSeeder.');
            return;
        }

        foreach ($biodataSiswa as $bio) {
            DaftarPesertaDidik::create([
                'walas_id' => $bio->walas_id,
                'nis' => $bio->nis,
                'nisn' => $bio->nisn,
                'nama_siswa' => $bio->siswas_id,
                'keterangan' => 'Siswa Aktif',
                'kurikulum_id' => $kurikulum->id,
                'tanggal' => now(),
                'jenis_kelamin' => $bio->jenis_kelamin,
            ]);
        }
    }
}