<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'no_wa',
        'password',
        'image_url'
    ];
    
}
