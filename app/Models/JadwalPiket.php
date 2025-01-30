<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'siswas_id',
        'nama_hari',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'detail_jadwal_pikets', 'jadwalpikets_id', 'siswas_id');
    }
}
