<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaKegiatanWalas extends Model
{
    use HasFactory;
    protected $fillable = [
            'hari', 
            'tanggal',
            'nama_kegiatan',
            'hasil',
            'waktu',
            'keterangan'
    ];
}
