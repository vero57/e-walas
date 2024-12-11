<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentitasKelas extends Model
{
    use HasFactory;
    protected $fillable = [
           'program_keahlian', 
           'kompetensi_keahlian', 
           'walas_id_10',
           'walas_id_11',
           'walas_id_12',
           'walas_id_13',
           'siswas_id_10',
           'siswas_id_11',
           'siswas_id_12',
           'siswas_id_13',
    ];
}
