<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapKehadiranSiswaGenap extends Model
{
    use HasFactory;

    // nama tabel
    protected $table = 'rekap_kehadiran_siswa_genaps';

    // kolom yang bisa diisi secara massal
    protected $fillable = [
        'walas_id',
        'siswas_id',
        'juli_sakit', 'juli_izin', 'juli_alfa', 'juli_jumlah',
        'agustus_sakit', 'agustus_izin', 'agustus_alfa', 'agustus_jumlah',
        'september_sakit', 'september_izin', 'september_alfa', 'september_jumlah',
        'oktober_sakit', 'oktober_izin', 'oktober_alfa', 'oktober_jumlah',
        'november_sakit', 'november_izin', 'november_alfa', 'november_jumlah',
        'desember_sakit', 'desember_izin', 'desember_alfa', 'desember_jumlah',
        'persentase_hadir', 'persentase_tidak_hadir'
    ];

    // relasi ke model siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // menghitung total sakit, izin, alfa untuk semua bulan
    public function getTotalSakitAttribute()
    {
        return $this->juli_sakit + $this->agustus_sakit + $this->september_sakit + $this->oktober_sakit + $this->november_sakit + $this->desember_sakit;
    }

    public function getTotalIzinAttribute()
    {
        return $this->juli_izin + $this->agustus_izin + $this->september_izin + $this->oktober_izin + $this->november_izin + $this->desember_izin;
    }

    public function getTotalAlfaAttribute()
    {
        return $this->juli_alfa + $this->agustus_alfa + $this->september_alfa + $this->oktober_alfa + $this->november_alfa + $this->desember_alfa;
    }

    // menghitung total kehadiran dan persentase hadir/tidak hadir
    public function hitungPersentase($total_hari_efektif)
    {
        $total_tidak_hadir = $this->total_sakit + $this->total_izin + $this->total_alfa;
        $total_hadir = $total_hari_efektif - $total_tidak_hadir;

        $this->persentase_hadir = ($total_hadir / $total_hari_efektif) * 100;
        $this->persentase_tidak_hadir = ($total_tidak_hadir / $total_hari_efektif) * 100;

        $this->save();
    }
}
