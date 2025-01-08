<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $guard = 'siswas'; 
    // Nama tabel utama
    protected $table = 'siswas';

    // Primary key di tabel asli
    protected $primaryKey = 'id';

    // Mengaktifkan timestamps
    public $timestamps = true;

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama',
        'rombels_id',
        'jenis_kelamin',
        'no_wa',
        'password',
        'image_url',
        'status'
    ];

    // Relasi ke tabel rombels
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombels_id', 'id');
    }
    
}
