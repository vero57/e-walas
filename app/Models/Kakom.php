<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kakom extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'no_wa',
        'password',
        'kompetensi',
        'image_url'
    ];
    public $timestamps = false;
}
