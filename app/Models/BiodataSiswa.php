<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
       'walas_id',
       'siswas_id',
       'nama_lengkap',
       'jenis_kelamin',
       'tempat_lahir',
       'tanggal_lahir',
       'alamat',
       'alamat_maps',
       'jalur_masuk',
       'jarak_rumah',
       'transportasi_sekolah',
       'transportasi_rumah',
       'agama', 
       'kewarganegaraan',
       'anak_ke',
       'jumlah_saudara',
       'no_wa',
       'email', 
       'nis', 
       'nisn', 
       'kelas', 
       'kompetensi', 
       'tahun_masuk', 
       'nama_ayah', 
       'pekerjaan_ayah', 
       'tempat_lahir_ayah',
       'tanggal_lahir_ayah',
       'alamat_ayah',
       'no_wa_ayah',
       'nama_ibu', 
       'pekerjaan_ibu', 
       'tempat_lahir_ibu',
       'tanggal_lahir_ibu',
       'alamat_ibu',
       'no_wa_ibu',
       'namasekolah_asal',
       'alamat_sekolah',
       'tahun_lulus',
       'riwayat_penyakit',
       'alergi',
       'prestasi_akademik',
       'prestasi_non_akademik',
       'pengalaman_ekskul',
       'kepribadian'
    ];
}
