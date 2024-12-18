<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPresensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'presensis_id',
        'siswas_id',
        'status'
        ];

    // relasi ke presensi
    public function presensi()
    {
        return $this->belongsTo(Presensi::class, 'presensis_id');
    }

    // relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id');
    }
}
