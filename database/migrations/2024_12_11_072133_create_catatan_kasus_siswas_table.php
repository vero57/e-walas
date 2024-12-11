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
        Schema::create('catatan_kasus_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama');
            $table->foreign('nama')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->string('kasus',255);
            $table->string('tindak_lanjut',255);
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_kasus_siswas');
    }
};
