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
        Schema::create("tindak_lanjut", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("pengaduan_id")
                ->constrained("pengaduan")
                ->onDelete("cascade");
            $table
                ->foreignId("eksekutor_id")
                ->constrained("users")
                ->onDelete("cascade");
            $table->text("catatan");
            $table->json("foto")->nullable(); // list array string photo path
            $table->enum("status", ["progress", "selesai", "terhambat"]);
            $table->date("tanggal_update");
            $table->timestamp("created_at")->useCurrent();
            $table->index(["pengaduan_id", "tanggal_update"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tindak_lanjut");
    }
};
