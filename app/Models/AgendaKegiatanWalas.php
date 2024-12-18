<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            'tanggal',
            'ttdwalas_url',
    ];
}
