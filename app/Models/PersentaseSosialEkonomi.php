<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersentaseSosialEkonomi extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'jenis_sosial_ekonomi',
        'jumlah',
        'persentase',
        'keterangan'
    ];
}
