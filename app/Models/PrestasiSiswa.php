<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswas_id', 
        'rombels_id', 
        'jenis_prestasi',
        'nama_prestasi',
        'tanggal',
        'sertifikat_url',
        'dokumentasi_url'
    ];
}
