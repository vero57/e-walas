<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasiKelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'kepala_sekolah',
        'walas',
        'ketuakelas',
        'waketuakelas',
        'bendahara',
        'seketaris',
        'seksi_kebersihan',
        'seksi_perlengkapan',
        'seksi_keamanan',
        'seksi_kerohanian'
    ];
}
