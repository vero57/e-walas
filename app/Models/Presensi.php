<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id', 
        'kelas', 
        'tanggal'
    ];

    // relasi ke wali kelas
    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id');
    }

    // relasi ke detail presensi
    public function detailPresensis()
    {
        return $this->hasMany(DetailPresensi::class, 'presensis_id');
    }
}
