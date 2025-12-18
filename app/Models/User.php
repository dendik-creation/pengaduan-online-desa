<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'alamat',
        'no_hp',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'pengguna_id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'pengguna_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pengguna_id');
    }

    public function penugasan()
    {
        return $this->hasMany(Penugasan::class, 'admin_id');
    }
}
