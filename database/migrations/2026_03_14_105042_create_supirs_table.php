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
    public function up() : void
    {
        Schema::create('supirs', function (Blueprint $table) {
            $table->string('supir_id', 10)->primary();
            $table->string('user_id', 10)->unique();
            $table->string('nama_supir', 100);
            $table->string('no_polisi', 15);
            $table->string('merk_truk', 50)->nullable();
            $table->year('tahun_truk')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('supirs');
    }
};
