<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BeritaAcaraKelulusan extends Model
{
    use HasFactory;

    
    protected $table = 'berita_acara_kelulusans';

    protected $fillable = [
        'walas_id',
        'waktu_tanggal',
        'tempat',
        'jumlah_peserta_rapat',
        'rombels_id',
        'kelas_baru',
        'laki_laki_lulus',
        'perempuan_lulus',
        'laki_laki_tidaklulus',
        'perempuan_tidaklulus',
    ];
    
     protected $casts = [
        'waktu_tanggal' => 'datetime',
    ];

    // Set locale ke Bahasa Indonesia
        public function getFormattedTanggalAttribute()
        {
            return Carbon::parse($this->waktu_tanggal)->locale('id')->translatedFormat('l, d F Y');
        }

        public function getFormattedJamAttribute()
        {
            return Carbon::parse($this->waktu_tanggal)->format('H:i') . ' WIB';
        }

        public function walas()
        {
            return $this->belongsTo(Walas::class, 'walas_id');
        }

        public function rombel()
        {
            return $this->belongsTo(Rombel::class, 'rombels_id');
        }
}

