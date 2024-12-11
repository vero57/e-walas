<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiJumlahSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'bulan',
        'jumlah_awal',
        'jumlah_akhir',
        'keterangan'
    ];
}
