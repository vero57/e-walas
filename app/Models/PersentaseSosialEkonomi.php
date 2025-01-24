<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\Factories\HasFactory;


class PersentaseSosialEkonomi extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'jenis_sosial_ekonomi',
        'jumlah',
        'persentase',
        'keterangan',
        'tanggal',
        'ttdwalas_url',
    ];
}
