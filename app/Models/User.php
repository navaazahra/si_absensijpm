<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\IDGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'role',
        'status_aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->user_id) {
                $user->user_id = IDGenerator::generate(self::class, 'user_id', 'USR');
            }
        });
    }

    public function supir()
    {
        return $this->hasOne(Supir::class, 'user_id', 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }

    public function petinggi()
    {
        return $this->hasOne(Petinggi::class, 'user_id', 'user_id');
    }

    public function getDisplayNameAttribute()
    {
        return match ($this->role) {
            'admin' => $this->admin?->nama_admin,
            'supir' => $this->supir?->nama_supir,
            'petinggi' => $this->petinggi?->nama_petinggi,
            default => $this->username,
        } ?? $this->username;
    }
}
