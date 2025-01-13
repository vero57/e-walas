<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Walas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'no_wa',
        'password',
        'nip',
        'image_url'
    ];
    public $timestamps = false;

    public function rombel()
    {
        return $this->hasMany(Rombel::class, 'walas_id', 'id');
    }

}
