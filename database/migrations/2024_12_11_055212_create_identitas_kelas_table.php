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
        Schema::create('identitas_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('program_keahlian', ['SIJA', 'TKJ', 'RPL', 'DKV', 'DPIB', 'TKP', 'TP','TFLM', 'TKR', 'TOI'])->default('SIJA');
            $table->enum('kompetensi_keahlian', ['SIJA', 'TKJ', 'RPL', 'DKV', 'DPIB', 'TKP', 'TP','TFLM', 'TKR', 'TOI'])->default('SIJA');
            $table->unsignedBigInteger('walas_id_10');
            $table->foreign('walas_id_10')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('walas_id_11');
            $table->foreign('walas_id_11')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('walas_id_12');
            $table->foreign('walas_id_12')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('walas_id_13');
            $table->foreign('walas_id_13')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('siswas_id_10');
            $table->foreign('siswas_id_10')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('siswas_id_11');
            $table->foreign('siswas_id_11')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('siswas_id_12');
            $table->foreign('siswas_id_12')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('siswas_id_13');
            $table->foreign('siswas_id_13')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_kelas');
    }
};
