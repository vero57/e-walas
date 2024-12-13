<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DenahTempatKerjaKelompok extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'nama_kelompok'
    ];
}
