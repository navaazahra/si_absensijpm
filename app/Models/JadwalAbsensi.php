<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IDGenerator;

class JadwalAbsensi extends Model
{
    use HasFactory;
    protected $table = 'jadwal_absensis';
    protected $primaryKey = 'jadwal_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'jadwal_id',
        'supir_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_absen_mulai',
        'jam_absen_selesai',
        'kota_asal',
        'kota_tujuan',
        'status_jadwal',
    ];

    protected static function booted()
    {
        static::creating(function ($jadwal) {
            if (!$jadwal->jadwal_id) {
                $jadwal->jadwal_id = IDGenerator::generate(self::class, 'jadwal_id', 'JDL');
            }
        });
    }
    
    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id', 'supir_id');
    }
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id', 'jadwal_id');
    }
}
