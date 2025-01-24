<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekapitulasiJumlahSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'bulan',
        'jumlah_awal_siswa',
        'jumlah_akhir_siswa',
        'keterangan',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];
}
