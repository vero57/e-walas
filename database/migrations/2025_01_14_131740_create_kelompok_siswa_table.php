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
        Schema::create('kelompok_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_id');
            $table->unsignedBigInteger('siswa_id');
            $table->timestamps();
    
            // Foreign Key untuk menghubungkan ke tabel denah_tempat_kerja_kelompoks
            $table->foreign('kelompok_id')->references('id')->on('denah_tempat_kerja_kelompoks')->onDelete('cascade');
    
            // Foreign Key untuk menghubungkan ke tabel siswas
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_siswa');
    }
};
