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
        Schema::create('kakoms', function (Blueprint $table) {
            $table->id();
            $table->string('nama',255);
            $table->string('no_wa',255);
            $table->string('password',255);
            $table->enum('kompetensi', ['SIJA', 'TKJ', 'RPL', 'DKV', 'DPIB', 'TKP', 'TP','TFLM', 'TKR', 'TOI'])->default('SIJA');
            $table->string('image_url',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kakoms');
    }
};
