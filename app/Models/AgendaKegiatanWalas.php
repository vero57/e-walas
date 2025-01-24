<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaKegiatanWalas extends Model
{
    use HasFactory;
    protected $fillable = [
            'walas_id',
            'hari', 
            'tanggal',
            'nama_kegiatan',
            'hasil',
            'waktu',
            'keterangan',
            'tanggalttd',
            'ttdwalas_url',
    ];
}
