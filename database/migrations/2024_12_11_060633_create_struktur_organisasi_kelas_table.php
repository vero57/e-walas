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
        Schema::create('struktur_organisasi_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('kepala_sekolah');
            $table->foreign('kepala_sekolah')->references('id')->on('kepseks')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('walas');
            $table->foreign('walas')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('ketuakelas');
            $table->foreign('ketuakelas')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('waketuakelas');
            $table->foreign('waketuakelas')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('bendahara');
            $table->foreign('bendahara')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('sekretaris');
            $table->foreign('sekretaris')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('seksi_kebersihan');
            $table->foreign('seksi_kebersihan')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('seksi_perlengkapan');
            $table->foreign('seksi_perlengkapan')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('seksi_keamanan');
            $table->foreign('seksi_keamanan')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('seksi_kerohanian');
            $table->foreign('seksi_kerohanian')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('kurikulum_id')->nullable();
            $table->foreign('kurikulum_id')->references('id')->on('kurikulums')->onDelete('cascade')->onUpdate ('cascade');
            $table->date('tanggal')->nullable();
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
        Schema::dropIfExists('struktur_organisasi_kelas');
    }
};
