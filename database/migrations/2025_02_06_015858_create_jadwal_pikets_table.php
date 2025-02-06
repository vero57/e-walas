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
        Schema::create('jadwal_pikets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('siswas_id')->nullable(); 
            $table->foreign('siswas_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_hari');
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
        Schema::dropIfExists('jadwal_pikets');
    }
};
