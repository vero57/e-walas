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
        Schema::create('data_keluar_rombel', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('nama_siswa');
            $table->foreign('nama_siswa')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('keterangan');
            $table->foreign('keterangan')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('rombels_id');
            $table->foreign('rombels_id')->references('id')->on('rombels')->onDelete('cascade')->onUpdate ('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_keluar_rombel');
    }
};
