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
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->unsignedInteger('kode_finger');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->time('terlambat')->nullable();
            $table->time('pulang_cepat')->nullable();
            $table->time('kehadiran')->nullable();
            $table->enum('jenis_perizinan', ['I', 'DL', 'S', 'CS', 'Prajab', 'CT', 'CM', 'CAP', 'CH', 'CB', 'A', 'TB']);
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->foreign('kode_finger')->references('kode_finger')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};