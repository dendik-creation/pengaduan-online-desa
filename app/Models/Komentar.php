<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komentar extends Model
{
    protected $table = 'komentar';
    
    public $timestamps = false;
    
    protected $fillable = [
        'pengaduan_id',
        'pengguna_id',
        'isi',
        'ditolak',
    ];

    protected $casts = [
        'ditolak' => 'boolean',
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
