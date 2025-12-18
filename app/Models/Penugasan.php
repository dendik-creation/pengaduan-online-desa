<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penugasan extends Model
{
    protected $table = 'penugasan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'pengaduan_id',
        'eksekutor_id',
        'admin_id',
        'tanggal_penugasan',
    ];

    protected $casts = [
        'tanggal_penugasan' => 'date',
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
     * Relationship dengan eksekutor (User dengan role eksekutor)
     */
    public function eksekutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'eksekutor_id');
    }

    /**
     * Relationship dengan admin (pengguna)
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Alias relationship ke admin agar konsisten penamaan 'pengguna'.
     * Memungkinkan eager load: penugasan.pengguna
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
