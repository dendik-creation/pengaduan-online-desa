<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'pengaduan_id',
        'pengguna_id',
        'nilai',
        'tipe',
        'keterangan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relationship dengan pengaduan
     */
    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Relationship dengan pengguna
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
