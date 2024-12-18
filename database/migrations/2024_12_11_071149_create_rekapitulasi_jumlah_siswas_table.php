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
        Schema::create('rekapitulasi_jumlah_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('bulan', ['Juli', 'Agustus','September','Oktober', 'November','Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'])->default('Juli');
            $table->unsignedInteger('jumlah_awal_siswa')->default(0);
            $table->unsignedInteger('jumlah_akhir_siswa')->default(0);
            $table->string('keterangan');
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
        Schema::dropIfExists('rekapitulasi_jumlah_siswas');
    }
};
