<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_pikets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'walas_id',
        'hari1', 'siswa1_id',
        'hari2', 'siswa2_id',
        'hari3', 'siswa3_id',
        'hari4', 'siswa4_id',
        'hari5', 'siswa5_id',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];

    /**
     * Get the siswa1 associated with this schedule.
     */
    public function siswa1()
    {
        return $this->belongsTo(Siswa::class, 'siswa1_id');
    }

    /**
     * Get the siswa2 associated with this schedule.
     */
    public function siswa2()
    {
        return $this->belongsTo(Siswa::class, 'siswa2_id');
    }

    /**
     * Get the siswa3 associated with this schedule.
     */
    public function siswa3()
    {
        return $this->belongsTo(Siswa::class, 'siswa3_id');
    }

    /**
     * Get the siswa4 associated with this schedule.
     */
    public function siswa4()
    {
        return $this->belongsTo(Siswa::class, 'siswa4_id');
    }

    /**
     * Get the siswa5 associated with this schedule.
     */
    public function siswa5()
    {
        return $this->belongsTo(Siswa::class, 'siswa5_id');
    }
}
