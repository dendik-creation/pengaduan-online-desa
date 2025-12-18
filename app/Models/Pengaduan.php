<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    protected $table = "pengaduan";

    protected $fillable = [
        "pengguna_id",
        "kategori_id",
        "tanggal_pengaduan",
        "lokasi",
        "rincian",
        "status",
        "foto",
    ];

    protected $casts = [
        "tanggal_pengaduan" => "date",
        "foto" => "array",
    ];

    /**
     * Relationship dengan pengguna
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, "pengguna_id");
    }

    /**
     * Relationship dengan kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPengaduan::class, "kategori_id");
    }

    /**
     * Relationship dengan komentar
     */
    public function komentar(): HasMany
    {
        return $this->hasMany(Komentar::class, "pengaduan_id");
    }

    /**
     * Relationship dengan ulasan
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, "pengaduan_id");
    }

    /**
     * Relationship dengan penugasan
     */
    public function penugasan(): HasMany
    {
        return $this->hasMany(Penugasan::class, "pengaduan_id");
    }

    /**
     * Relationship dengan tindak lanjut
     */
    public function tindakLanjut(): HasMany
    {
        return $this->hasMany(TindakLanjut::class, "pengaduan_id");
    }

}
