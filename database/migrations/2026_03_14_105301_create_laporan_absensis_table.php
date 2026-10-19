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
        Schema::create('laporan_absensis', function (Blueprint $table) {
            $table->string('laporan_id', 10)->primary();
            $table->string('dibuat_oleh', 10);
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->string('petinggi_id', 10)->nullable();
            $table->string('file_laporan', 30)->nullable();
            $table->enum('status_laporan', ['draft', 'final'])->default('draft');
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('admin_id')->on('admins')->cascadeOnDelete();
            $table->foreign('petinggi_id')->references('petinggi_id')->on('petinggis')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_absensis');
    }
};
