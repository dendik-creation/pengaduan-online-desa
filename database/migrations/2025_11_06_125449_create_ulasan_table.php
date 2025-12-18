<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->foreignId('pengguna_id')->constrained('users')->onDelete('cascade');
            $table->integer('nilai')->comment('Rating 1-5');
            $table->enum('tipe', ['kepuasan', 'kualitas', 'kecepatan']);
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['pengaduan_id', 'tipe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
