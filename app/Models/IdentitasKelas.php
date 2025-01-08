<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'walas_id', 'program_keahlian', 'kompetensi_keahlian', 
        'walas_id_10', 'walas_id_11', 'walas_id_12', 'walas_id_13',
        'siswas_id_10', 'siswas_id_11', 'siswas_id_12', 'siswas_id_13',
    ];

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id');
    }

    public function siswas()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id_10');
        // kamu bisa menambahkan relasi lainnya untuk siswas_id_11, siswas_id_12, siswas_id_13 jika perlu
    }
}
