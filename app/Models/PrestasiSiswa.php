<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'siswas_id', 
        'rombels_id', 
        'jenis_prestasi',
        'nama_prestasi',
        'tanggal',
        'sertifikat_url',
        'dokumentasi_url'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id', 'id');
    }
}
