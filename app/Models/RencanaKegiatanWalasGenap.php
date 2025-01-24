<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKegiatanWalasGenap extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'minggu_ke',
        'kegiatan_bukti',
        'keterangan',
        'kurikulum_id',
        'tanggalttd',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id');
    }
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }
}
