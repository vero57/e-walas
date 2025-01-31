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
        Schema::create('prestasi_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswas_id')->nullable(); 
            $table->foreign('siswas_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rombels_id')->nullable(); 
            $table->foreign('rombels_id')->references('id')->on('rombels')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('jenis_prestasi', ['Akademik', 'Non-akademik'])->default('Akademik');
            $table->string('nama_prestasi');
            $table->date('tanggal')->nullable();
            $table->string('sertifikat_url',255)->nullable();
            $table->string('dokumentasi_url',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_siswas');
    }
};
