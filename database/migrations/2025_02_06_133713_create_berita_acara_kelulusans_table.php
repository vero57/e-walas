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
        Schema::create('berita_acara_kelulusans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->datetime('waktu_tanggal');
            $table->string('tempat',20);
            $table->string('jumlah_peserta_rapat',5);
            $table->unsignedBigInteger('rombels_id');
            $table->foreign('rombels_id')->references('id')->on('rombels')->onDelete('cascade')->onUpdate ('cascade');
            $table->string('laki_laki_lulus',5);
            $table->string('perempuan_lulus',5);
            $table->string('laki_laki_tidaklulus',5);
            $table->string('perempuan_tidaklulus',5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara_kelulusans');
    }
};
