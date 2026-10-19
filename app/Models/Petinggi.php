<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IDGenerator;

class Petinggi extends Model
{
    use HasFactory;
    protected $table = 'petinggis';
    protected $primaryKey = 'petinggi_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'petinggi_id',
        'user_id',
        'nama_petinggi',
        'jabatan',
        'no_hp',
        'alamat',
    ];

    protected static function booted()
    {
        static::creating(function ($petinggi) {
            if (!$petinggi->petinggi_id) {
                $petinggi->petinggi_id = IDGenerator::generate(self::class, 'petinggi_id', 'PTG');
            }
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function laporanFinal()
    {
        return $this->hasMany(LaporanAbsensi::class, 'petinggi_id', 'petinggi_id');
    }
}
