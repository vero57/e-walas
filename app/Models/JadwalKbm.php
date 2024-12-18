<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKbm extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_kbms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'walas_id',
        'hari1', 'mapel1_id', 'guru1_id',
        'hari2', 'mapel2_id', 'guru2_id',
        'hari3', 'mapel3_id', 'guru3_id',
        'hari4', 'mapel4_id', 'guru4_id',
        'hari5', 'mapel5_id', 'guru5_id',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];

    /**
     * Get the mapel1 associated with this schedule.
     */
    public function mapel1()
    {
        return $this->belongsTo(Mapel::class, 'mapel1_id');
    }

    /**
     * Get the guru1 associated with this schedule.
     */
    public function guru1()
    {
        return $this->belongsTo(Guru::class, 'guru1_id');
    }

    /**
     * Get the mapel2 associated with this schedule.
     */
    public function mapel2()
    {
        return $this->belongsTo(Mapel::class, 'mapel2_id');
    }

    /**
     * Get the guru2 associated with this schedule.
     */
    public function guru2()
    {
        return $this->belongsTo(Guru::class, 'guru2_id');
    }

    /**
     * Get the mapel3 associated with this schedule.
     */
    public function mapel3()
    {
        return $this->belongsTo(Mapel::class, 'mapel3_id');
    }

    /**
     * Get the guru3 associated with this schedule.
     */
    public function guru3()
    {
        return $this->belongsTo(Guru::class, 'guru3_id');
    }

    /**
     * Get the mapel4 associated with this schedule.
     */
    public function mapel4()
    {
        return $this->belongsTo(Mapel::class, 'mapel4_id');
    }

    /**
     * Get the guru4 associated with this schedule.
     */
    public function guru4()
    {
        return $this->belongsTo(Guru::class, 'guru4_id');
    }

    /**
     * Get the mapel5 associated with this schedule.
     */
    public function mapel5()
    {
        return $this->belongsTo(Mapel::class, 'mapel5_id');
    }

    /**
     * Get the guru5 associated with this schedule.
     */
    public function guru5()
    {
        return $this->belongsTo(Guru::class, 'guru5_id');
    }
}
