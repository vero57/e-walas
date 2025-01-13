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
        Schema::create('rencana_kegiatan_walas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->enum('minggu_ke', ['1', '2', '3', '4', '5', '6', '7','8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'])->default('1');
            $table->enum('kegiatan_bukti', [
                'Menyusun program / mengisi adm wali kelas - Adm Wali kelas',
                'Menyusun struktur organisasi kelas - Organigram',
                'Sosialisasi sistem pemelajaran Kurikulum 2013 atau Kurikulum Merdeka - Absensi',
                'Menata tempat duduk di kelas - Denah kelas',
                'Membagi biodata peserta didik - Ada bio data',
                'Mengisi data peserta - Ada data peserta',
                'Membimbing peserta didik - Ada daftar bimbingan',
                'Mengecek kehadiran peserta didik - Ada rekap',
                'Menindaklanjuti hasil pengecekan absensi - Pemang. / homevisit',
                'Membenahi keadaan kelas - Kelas tertata / lengkap',
                'Mengontrol kemajuan hasil pemelajaran - Rekaman kegiatan',
                'Visit Class - Surat tugas',
                'Home Visit - Rekaman kegiatan',
                'Rekapitulasi nilai kompetensi - Rekap nilai',
                'Membimbing remedial peserta didik - Daftar Remedial',
                'Mengisi Leger - Ada Leger',
                'Mengisi Buku Laporan - Ada buku Laporan',
                'Membagi dokumen hasil pembelajaran - Daftar serah terima raport'
            ])->default('Membagi dokumen hasil pembelajaran - Daftar serah terima raport');
            $table->enum('keterangan', ['true', 'false'])->default('false');
            $table->unsignedBigInteger('kurikulum_id')->nullable();
            $table->foreign('kurikulum_id')->references('id')->on('kurikulums')->onDelete('cascade')->onUpdate ('cascade');
            $table->date('tanggalttd')->nullable();
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
        Schema::dropIfExists('rencana_kegiatan_walas');
    }
};
