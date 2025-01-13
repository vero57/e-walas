<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrukturOrganisasiKelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'kepala_sekolah',
        'walas',
        'ketuakelas',
        'waketuakelas',
        'bendahara',
        'sekretaris',
        'seksi_kebersihan',
        'seksi_perlengkapan',
        'seksi_keamanan',
        'seksi_kerohanian',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];
}
