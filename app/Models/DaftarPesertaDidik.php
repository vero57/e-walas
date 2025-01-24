<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'jenis_kelamin',
        'ttdwalas_url',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nama_siswa', 'id');
    }

}
