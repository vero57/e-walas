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
        Schema::create('persentase_sosial_ekonomis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->string('jenis_sosial_ekonomi'); // Ubah tipe data menjadi string
            $table->string('jumlah', 50);
            $table->string('persentase', 50);
            $table->string('keterangan', 255);
            $table->date('tanggal');
            $table->string('ttdwalas_url', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persentase_sosial_ekonomis');
    }
};
