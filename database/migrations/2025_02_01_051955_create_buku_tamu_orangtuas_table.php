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
        Schema::create('buku_tamu_orangtuas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->date('tanggal');
            $table->string('nama_peserta_didik',255);
            $table->string('nama_orang_tua',255);
            $table->string('tindak_lanjut',255);
            $table->string('kasus',255);
            $table->string('solusi',255);
            $table->string('dokumentasi_url',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_tamu_orangtuas');
    }
};