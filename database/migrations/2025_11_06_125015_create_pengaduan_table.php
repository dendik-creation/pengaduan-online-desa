<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("pengaduan", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("pengguna_id")
                ->constrained("users")
                ->onDelete("cascade");
            $table
                ->foreignId("kategori_id")
                ->constrained("kategori_pengaduan")
                ->onDelete("cascade");
            $table->date("tanggal_pengaduan");
            $table->string("lokasi");
            $table->text("rincian");
            $table
                ->enum("status", ["baru", "diproses", "selesai", "ditolak"])
                ->default("baru");
            $table->json("foto")->nullable(); // list array string photo path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("pengaduan");
    }
};
