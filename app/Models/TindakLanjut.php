<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TindakLanjut extends Model
{
    protected $table = 'tindak_lanjut';
    
    public $timestamps = false;
    
    protected $fillable = [
        'pengaduan_id',
        'eksekutor_id',
        'catatan',
        'foto',
        'status',
        'tanggal_update',
    ];

    protected $casts = [
        'tanggal_update' => 'date',
        'created_at' => 'datetime',
        'foto' => 'array',
    ];

    /**
     * Relationship dengan pengaduan
     */
    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Relationship dengan eksekutor (User dengan role eksekutor)
     */
    public function eksekutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'eksekutor_id');
    }

    /**
     * Alias untuk backward compatibility
     */
    public function anggota(): BelongsTo
    {
        return $this->eksekutor();
    }
}
