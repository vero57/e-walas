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
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('hari1', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('siswa1_id');
            $table->foreign('siswa1_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari2', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('siswa2_id');
            $table->foreign('siswa2_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari3', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('siswa3_id');
            $table->foreign('siswa3_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari4', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('siswa4_id');
            $table->foreign('siswa4_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari5', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('siswa5_id');
            $table->foreign('siswa5_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');

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
