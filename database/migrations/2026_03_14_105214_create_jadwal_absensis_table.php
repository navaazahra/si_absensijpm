<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('jadwal_absensis', function (Blueprint $table) {
            $table->string('jadwal_id', 10)->primary();
            $table->string('supir_id', 10);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_absen_mulai');
            $table->time('jam_absen_selesai');
            $table->string('kota_asal', 100);
            $table->string('kota_tujuan', 100);
            $table->enum('status_jadwal', ['aktif', 'nonaktif', 'selesai'])->default('aktif');
            $table->timestamps();

            $table->foreign('supir_id')->references('supir_id')->on('supirs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_absensis');
    }
};
