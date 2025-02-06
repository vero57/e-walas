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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama_siswa');
            $table->foreign('nama_siswa')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('keterangan');
            $table->foreign('keterangan')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
