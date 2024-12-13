<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaKegiatanWalasGenap extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'minggu_ke',
        'kegiatan_bukti',
        'keterangan',
    ];
}
