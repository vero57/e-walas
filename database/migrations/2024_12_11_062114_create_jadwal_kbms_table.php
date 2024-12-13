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
        Schema::create('jadwal_kbms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('hari1', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('mapel1_id');
            $table->foreign('mapel1_id')->references('id')->on('mapels')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('guru1_id');
            $table->foreign('guru1_id')->references('id')->on('gurus')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari2', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('mapel2_id');
            $table->foreign('mapel2_id')->references('id')->on('mapels')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('guru2_id');
            $table->foreign('guru2_id')->references('id')->on('gurus')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari3', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('mapel3_id');
            $table->foreign('mapel3_id')->references('id')->on('mapels')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('guru3_id');
            $table->foreign('guru3_id')->references('id')->on('gurus')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari4', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('mapel4_id');
            $table->foreign('mapel4_id')->references('id')->on('mapels')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('guru4_id');
            $table->foreign('guru4_id')->references('id')->on('gurus')->onDelete('cascade')->onUpdate ('cascade');

            $table->enum('hari5', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->default('senin');
            $table->unsignedBigInteger('mapel5_id');
            $table->foreign('mapel5_id')->references('id')->on('mapels')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('guru5_id');
            $table->foreign('guru5_id')->references('id')->on('gurus')->onDelete('cascade')->onUpdate ('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kbms');
    }
};
