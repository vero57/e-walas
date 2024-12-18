<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kurikulum extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'no_wa',
        'password',
        'nip',
        'image_url'
    ];
    
}
