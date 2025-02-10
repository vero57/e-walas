<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumnis'; 
    protected $fillable = ['siswa_id', 'nama', 'no_wa', 'rombels_id'];

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombels_id', 'id');
    }

}
