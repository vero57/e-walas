<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LembarPengesahan extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'image_url'
    ];

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id', 'id');
    }
}
