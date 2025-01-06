<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rombel extends Model
{
    use HasFactory;
    protected $fillable = [
        'tingkat',
        'kompetensi',
        'nama_kelas',
        'walas_id'
    ];
    public $timestamps = false;
}
