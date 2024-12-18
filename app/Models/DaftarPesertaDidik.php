<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPesertaDidik extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'nis',
        'nisn',
        'nama_siswa',
        'keterangan',
        'tanggal',
        'ttdwalas_url',
    ];
}
