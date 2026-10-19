<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IDGenerator;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensis';
    protected $primaryKey = 'absensi_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'absensi_id',
        'supir_id',
        'jadwal_id',
        'waktu_absensi',
        'latitude',
        'longitude',
        'foto',
        'status_absensi',
        'alasan',
        'divalidasi_oleh',
        'waktu_validasi',
        'alasan_penolakan',
    ];

    protected $casts = [
        'waktu_absensi' => 'datetime',
        'waktu_validasi' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($absensi) {
            if (!$absensi->absensi_id) {
                $absensi->absensi_id = IDGenerator::generate(self::class, 'absensi_id', 'ABS');
            }
        });
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalAbsensi::class, 'jadwal_id', 'jadwal_id');
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id', 'supir_id');
    }

    public function validator()
    {
        return $this->belongsTo(Admin::class, 'divalidasi_oleh', 'admin_id');
    }

}
