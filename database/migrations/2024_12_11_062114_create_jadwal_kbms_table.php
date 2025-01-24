<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKbmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kbms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombels_id')->constrained('rombels')->onDelete('cascade')->onUpdate ('cascade');
            $table->foreignId('walas_id')->constrained('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->foreignId('kurikulum_id')->nullable()->constrained('kurikulums')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->string('ttdkurikulum_url')->nullable();
            $table->string('ttdwalas_url')->nullable();

            // kolom buat hari dan jam (1-12) untuk semua hari
            $table->json('senin')->nullable();  // simpan data mapel_id + guru_id tiap jam
            $table->json('selasa')->nullable();
            $table->json('rabu')->nullable();
            $table->json('kamis')->nullable();
            $table->json('jumat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_kbms');
    }
}
