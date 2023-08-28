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
        Schema::create('perizinan', function (Blueprint $table) {
            $table->increments('id_perizinan');
            $table->unsignedInteger('id_atasan');
            $table->string('kode_finger', 8);
            $table->enum('jenis_perizinan', ['I', 'DL', 'S', 'CS', 'Prajab', 'CT', 'CM', 'CAP', 'CH', 'CB', 'A', 'TB']);
            $table->date('tgl_ajuan');
            $table->date('tgl_absen_awal');
            $table->date('tgl_absen_akhir');
            $table->string('keterangan', 100);
            $table->string('file_perizinan', 255);
            $table->enum('status_izin_atasan', ['0','1'])->nullable()->default(null);
            $table->string('alasan_ditolak_atasan', 255)->nullable();
            $table->enum('status_izin_ppk', ['0','1'])->nullable()->default(null);
            $table->string('alasan_ditolak_ppk', 255)->nullable();
            $table->integer('jumlah_hari_pengajuan')->nullable();
            $table->foreign('id_atasan')->references('id_users')->on('users')->onDelete('cascade');
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};