<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BiodataSiswa; 
use App\Models\Siswa;
use Faker\Factory as Faker;

class BiodataSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswas = Siswa::with('rombel.walas')->get();

        if ($siswas->isEmpty()) {
            $this->command->info('Tidak ada data Siswa, lewati BiodataSiswaSeeder.');
            return;
        }

        foreach ($siswas as $siswa) {
            if ($siswa->rombel && $siswa->rombel->walas) {
                BiodataSiswa::create([
                    'walas_id' => $siswa->rombel->walas->id,
                    'siswas_id' => $siswa->id,
                    'nama_lengkap' => $siswa->nama,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date('Y-m-d', '2008-12-31'),
                    'alamat' => $faker->address,
                    'alamat_maps' => $faker->url,
                    'kepemilikan_rumah' => $faker->randomElement(['Lunas', 'Sewa', 'KPR/Kredit', 'Kontrak']),
                    'jalur_masuk' => $faker->randomElement(['Afirmasi', 'Zonasi', 'Rapor', 'Prestasi']),
                    'jarak_rumah' => $faker->numberBetween(1, 15) . ' km',
                    'transportasi_sekolah' => 'Motor',
                    'transportasi_rumah' => 'Motor',
                    'agama' => 'Islam',
                    'kewarganegaraan' => 'Indonesia',
                    'anak_ke' => $faker->numberBetween(1, 4),
                    'jumlah_saudara' => $faker->numberBetween(1, 4),
                    'no_wa' => $siswa->no_wa,
                    'email' => $faker->unique()->safeEmail,
                    'nis' => $faker->unique()->numerify('10##########'),
                    'nisn' => $faker->unique()->numerify('00########'),
                    'kelas' => $siswa->rombel->tingkat,
                    'kompetensi' => $siswa->rombel->kompetensi,
                    'tahun_masuk' => '2023',
                    'nama_ayah' => $faker->name('male'),
                    'pekerjaan_ayah' => $faker->jobTitle,
                    'tempat_lahir_ayah' => $faker->city,
                    'tanggal_lahir_ayah' => $faker->date('Y-m-d', '1985-12-31'),
                    'alamat_ayah' => $faker->address,
                    'no_wa_ayah' => $faker->numerify('08##########'),
                    'nama_ibu' => $faker->name('female'),
                    'pekerjaan_ibu' => $faker->jobTitle,
                    'tempat_lahir_ibu' => $faker->city,
                    'tanggal_lahir_ibu' => $faker->date('Y-m-d', '1988-12-31'),
                    'alamat_ibu' => $faker->address,
                    'no_wa_ibu' => $faker->numerify('08##########'),
                    'pendapatan_ortu' => 'Rp ' . $faker->numberBetween(3, 10) . '.000.000',
                    'namasekolah_asal' => 'SMP Negeri ' . $faker->numberBetween(1, 5) . ' ' . $faker->city,
                    'alamat_sekolah' => $faker->address,
                    'tahun_lulus' => '2023',
                    'riwayat_penyakit' => 'Tidak Ada',
                    'alergi' => 'Tidak Ada',
                    'prestasi_akademik' => 'Tidak Ada',
                    'prestasi_non_akademik' => 'Tidak Ada',
                    'pengalaman_ekskul' => 'Pramuka',
                    'kepribadian' => 'Baik',
                ]);
            }
        }
    }
}