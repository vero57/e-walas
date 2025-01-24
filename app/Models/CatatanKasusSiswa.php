<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatatanKasusSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
            'walas_id',
            'siswas_id', 
            'kasus',
            'tindak_lanjut',
            'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id', 'id');
    }
}