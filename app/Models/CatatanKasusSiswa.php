<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanKasusSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
                    

            'nama', 
            'kasus',
            'tindak_lanjut',
            'keterangan'
    ];
}
