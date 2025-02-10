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
        Schema::create('keluar_rombels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama_siswa');
            $table->foreign('nama_siswa')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('keterangan', ['naik_kelas', 'tidak_naik_kelas', 'pindah_sekolah']);
            $table->unsignedBigInteger('rombels_id');
            $table->foreign('rombels_id')->references('id')->on('rombels')->onDelete('cascade')->onUpdate ('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluar_rombels');
    }
};
