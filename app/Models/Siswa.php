<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Rombel;

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
    
    public function denahTempatKerjaKelompok()
    {
        return $this->belongsTo(DenahTempatKerjaKelompok::class);
    }

    public function kelompok()
    {
        return $this->belongsToMany(DenahTempatKerjaKelompok::class, 'kelompok_siswa', 'siswa_id', 'kelompok_id');
    }

    public function biodata()
    {
        return $this->hasOne(BiodataSiswa::class, 'siswas_id', 'id');
    }

    public function biodataSiswa()
    {
        return $this->hasOne(BiodataSiswa::class, 'siswas_id', 'id'); // Sesuaikan nama kolom jika berbeda
    }

    public function daftarPesertaDidik()
    {
        return $this->hasMany(DaftarPesertaDidik::class, 'nama_siswa', 'id');
    }

    public function detailPresensis()
    {
        return $this->hasMany(DetailPresensi::class, 'siswa_id');
    }

    public function keluarRombel()
    {
        return $this->hasOne(KeluarRombel::class, 'siswa_id'); // Menghubungkan Siswa dengan KeluarRombel berdasarkan siswa_id
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($siswa) {
            if ($siswa->status == 'nonaktif') {
                Alumni::create([
                    'nama_siswa' => $siswa->id, 
                    'status' => $siswa->status,
                ]);

                $siswa->delete(); // Hapus dari siswas setelah pindah ke alumni
            }
        });
    }

}
