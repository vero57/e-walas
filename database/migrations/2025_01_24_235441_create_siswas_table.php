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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama',255);
            $table->unsignedBigInteger('rombels_id');
            $table->foreign('rombels_id')->references('id')->on('rombels')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki'])->default('Laki-laki');
            $table->string('no_wa',15);
            $table->string('password',255);
            $table->string('image_url',255)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->enum('keterangan', ['naik_kelas', 'tidak_naik_kelas', 'pindah_sekolah'])->default('naik_kelas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};