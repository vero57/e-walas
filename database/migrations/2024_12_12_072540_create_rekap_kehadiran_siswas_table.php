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
        Schema::create('rekap_kehadiran_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('walas_id');
            $table->foreign('walas_id')->references('id')->on('walas')->onDelete('cascade')->onUpdate ('cascade');
            $table->unsignedBigInteger('siswas_id');
            $table->foreign('siswas_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate ('cascade');
            // data bulan juli
    $table->smallInteger('juli_sakit')->default(0);
    $table->smallInteger('juli_izin')->default(0);
    $table->smallInteger('juli_alfa')->default(0);
    $table->smallInteger('juli_jumlah')->default(0); // total hari sakit + izin + alfa
    
    // data bulan agustus
    $table->smallInteger('agustus_sakit')->default(0);
    $table->smallInteger('agustus_izin')->default(0);
    $table->smallInteger('agustus_alfa')->default(0);
    $table->smallInteger('agustus_jumlah')->default(0);

    // data bulan lainnya
    $table->smallInteger('september_sakit')->default(0);
    $table->smallInteger('september_izin')->default(0);
    $table->smallInteger('september_alfa')->default(0);
    $table->smallInteger('september_jumlah')->default(0);

    $table->smallInteger('oktober_sakit')->default(0);
    $table->smallInteger('oktober_izin')->default(0);
    $table->smallInteger('oktober_alfa')->default(0);
    $table->smallInteger('oktober_jumlah')->default(0);

    $table->smallInteger('november_sakit')->default(0);
    $table->smallInteger('november_izin')->default(0);
    $table->smallInteger('november_alfa')->default(0);
    $table->smallInteger('november_jumlah')->default(0);

    $table->smallInteger('desember_sakit')->default(0);
    $table->smallInteger('desember_izin')->default(0);
    $table->smallInteger('desember_alfa')->default(0);
    $table->smallInteger('desember_jumlah')->default(0);

    // persentase kehadiran
    $table->float('persentase_hadir')->default(0); // total hadir (H) dalam %
    $table->float('persentase_tidak_hadir')->default(0); // total tidak hadir (TH) dalam %
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_kehadiran_siswas');
    }
};
