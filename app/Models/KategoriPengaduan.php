<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPengaduan extends Model
{
    protected $table = 'kategori_pengaduan';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    /**
     * Relationship dengan pengaduan
     */
    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}
