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
        Schema::create('absensis', function (Blueprint $table) {
            $table->string('absensi_id', 10)->primary();
            $table->string('supir_id', 10);
            $table->string('jadwal_id', 10);
            $table->dateTime('waktu_absensi');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('foto');
            $table->enum('status_absensi', [
                            'normal',
                            'perlu_konfirmasi',
                            'disetujui',
                            'ditolak'
            ])->default('normal');
            $table->text('alasan')->nullable();
            $table->string('divalidasi_oleh', 10)->nullable();
            $table->dateTime('waktu_validasi')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();

            $table->foreign('supir_id')->references('supir_id')->on('supirs')->cascadeOnDelete();
            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal_absensis')->cascadeOnDelete();
            $table->foreign('divalidasi_oleh')->references('admin_id')->on('admins')->nullOnDelete();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
