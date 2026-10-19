<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IDGenerator;

class LaporanAbsensi extends Model
{
    use HasFactory;
    protected $table = 'laporan_absensis';
    protected $primaryKey = 'laporan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'laporan_id',
        'dibuat_oleh',
        'periode_awal',
        'periode_akhir',
        'petinggi_id',
        'file_laporan',
        'status_laporan',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($laporan) {
            if (!$laporan->laporan_id) {
                $laporan->laporan_id = IDGenerator::generate(self::class, 'laporan_id', 'LPR');
            }
        });
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'dibuat_oleh', 'admin_id');
    }

    public function petinggi()
    {
        return $this->belongsTo(Petinggi::class, 'petinggi_id', 'petinggi_id');
    }
}
