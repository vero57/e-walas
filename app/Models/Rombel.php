<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $fillable = [
        'tingkat',
        'kompetensi',
        'nama_kelas',
        'walas_id'
    ];
}
