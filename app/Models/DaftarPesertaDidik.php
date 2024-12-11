<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPesertaDidik extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'nisn',
        'nama_siswa',
        'keterangan'
    ];
}
