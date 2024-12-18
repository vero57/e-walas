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
        Schema::create('daftar_peserta_didiks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('nis');
            $table->foreign('nis')->references('id')->on('biodata_siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('nisn');
            $table->foreign('nisn')->references('id')->on('biodata_siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('nama_siswa');
            $table->foreign('nama_siswa')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->string('keterangan', 50);
            $table->unsignedBigInteger('kurikulum_id');
            $table->foreign('kurikulum_id')->references('id')->on('kurikulums')->onDelete('cascade')->onUpdate ('cascade');
            $table->date('tanggal');
            $table->string('ttdkurikulum_url',255)->nullable();
            $table->string('ttdwalas_url',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_peserta_didiks');
    }
};
