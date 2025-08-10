<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Walas; 

class DenahTempatKerjaKelompok extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'walas_id',
        'siswas_id',
        'nama_kelompok'
    ];


    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'kelompok_siswa', 'kelompok_id', 'siswa_id');
    }

    public function walas()
    {
        return $this->belongsTo(Walas::class);
    }
}
