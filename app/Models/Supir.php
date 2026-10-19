<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IDGenerator;

class Supir extends Model
{
    protected $table = 'supirs';
    protected $primaryKey = 'supir_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'supir_id',
        'user_id',
        'nama_supir',
        'no_polisi',
        'merk_truk',
        'tahun_truk',
        'no_hp',
        'alamat',
    ];

    protected static function booted()
    {
        static::creating(function ($supir) {
            if (!$supir->supir_id) {
                $supir->supir_id = IDGenerator::generate(self::class, 'supir_id', 'SPR');
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function jadwalAbsensis()
    {
        return $this->hasMany(JadwalAbsensi::class, 'supir_id', 'supir_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'supir_id', 'supir_id');
    }
}
