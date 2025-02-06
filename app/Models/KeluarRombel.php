<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeluarRombel extends Model
{
     // Tentukan nama tabel jika tidak menggunakan nama default
     protected $table = 'data_keluar_rombel'; // Sesuaikan dengan nama tabel di database
     // Kolom yang dapat diisi
     protected $fillable = [
        'nama_siswa',
        'keterangan',
        'rombels_id',
    ];
}
