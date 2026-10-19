<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IDGenerator;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'admin_id',
        'user_id',
        'nama_admin',
        'no_hp',
        'alamat',
    ];

    protected static function booted()
    {
        static::creating(function ($admin) {
            if (!$admin->admin_id) {
                $admin->admin_id = IDGenerator::generate(self::class, 'admin_id', 'ADM');
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function validasiAbsensis()
    {
        return $this->hasMany(Absensi::class, 'divalidasi_oleh', 'admin_id');
    }

    public function laporanAbsensis()
    {
        return $this->hasMany(LaporanAbsensi::class, 'dibuat_oleh', 'admin_id');
    }
}
