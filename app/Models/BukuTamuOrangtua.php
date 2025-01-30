<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BukuTamuOrangtua extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'tanggal',
        'nama_peserta_didik',
        'tindak_lanjut',
        'kasus',
        'solusi',
        'dokumentasi_url'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nama_peserta_didik', 'id');
    }
    
    public function siswaedit()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    
}
