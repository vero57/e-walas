<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kepsek extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'no_wa',
        'password',
        'image_url'
    ];
    public $timestamps = false;
}
