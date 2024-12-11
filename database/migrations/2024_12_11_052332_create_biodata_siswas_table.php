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
        Schema::create('biodata_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswas_id');
            $table->foreign('siswas_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            $table->string('jenis_kelamin',255);
            $table->string('tempat_lahir',255);
            $table->date('tanggal_lahir',255);
            $table->string('alamat',255);
            $table->string('alamat_maps',255);
            $table->enum('jalur_masuk', ['Afirmasi', 'Zonasi', 'Rapor', 'Prestasi', 'Anak Guru','Perpindahan Orang Tua',])->default('Rapor');
            $table->string('jarak_rumah',255);
            $table->string('transportasi_sekolah',255);
            $table->string('transportasi_rumah',255);
            $table->enum('agama', ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Budha','Konghucu',])->default('Islam');
            $table->string('kewarganegaraan',20);
            $table->string('anak_ke',5);
            $table->string('jumlah_saudara', 5);
            $table->string('no_wa', 50);
            $table->string('email', 50);
            $table->string('nis', 50);
            $table->string('nisn', 50);
            $table->string('kelas', 50);
            $table->enum('kompetensi', ['SIJA', 'TKJ', 'RPL', 'DKV', 'DPIB', 'TKP', 'TP','TFLM', 'TKR', 'TOI'])->default('SIJA');
            $table->string('tahun_masuk', 50);
            $table->string('nama_ayah', 80);
            $table->string('pekerjaan_ayah', 80);
            $table->string('tempat_lahir_ayah',50);
            $table->date('tanggal_lahir_ayah',50);
            $table->string('alamat_ayah',50);
            $table->string('no_wa_ayah',50);
            $table->string('nama_ibu', 50);
            $table->string('pekerjaan_ibu', 50);
            $table->string('tempat_lahir_ibu',50);
            $table->date('tanggal_lahir_ibu',50);
            $table->string('alamat_ibu',50);
            $table->string('no_wa_ibu',50);
            $table->string('namasekolah_asal',50);
            $table->string('alamat_sekolah',50);
            $table->string('tahun_lulus',50);
            $table->string('riwayat_penyakit',50);
            $table->string('alergi',50);
            $table->string('prestasi_akademik',50);
            $table->string('prestasi_non_akademik',50);
            $table->string('pengalaman_ekskul',50);
            $table->text('kepribadian',500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata_siswas');
    }
};
