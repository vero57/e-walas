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

    public function walas10()
{
    return $this->belongsTo(Walas::class, 'walas_id_10'); // Pastikan tabel Walas menyimpan nama walas
}

public function walas11()
{
    return $this->belongsTo(Walas::class, 'walas_id_11');
}

public function walas12()
{
    return $this->belongsTo(Walas::class, 'walas_id_12');
}

public function walas13()
{
    return $this->belongsTo(Walas::class, 'walas_id_13');
}

public function siswa10()
{
    return $this->belongsTo(Siswa::class, 'siswas_id_10'); // Sesuaikan dengan model siswa
}

public function siswa11()
{
    return $this->belongsTo(Siswa::class, 'siswas_id_11');
}

public function siswa12()
{
    return $this->belongsTo(Siswa::class, 'siswas_id_12');
}

public function siswa13()
{
    return $this->belongsTo(Siswa::class, 'siswas_id_13');
}

}
