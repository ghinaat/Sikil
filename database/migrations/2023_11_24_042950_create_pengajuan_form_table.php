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
        Schema::create('pengajuan_form', function (Blueprint $table) {
            $table->increments('id_pengajuan_form');
            $table->unsignedInteger('id_users');
            $table->date('tgl_pengajuan');
            $table->enum('jenis_form',['Biodata', 'Daftar Hadir', 'Evaluasi', 'Konfirmasi Keikutsertaan', 'Pendaftaran', 'Pengumpulan Tugas', 'Validasi ']);
            $table->string('nama_kegiatan', 255);
            $table->date('tgl_digunakan');
            $table->enum('bahasa', ['Indonesia', 'Inggris']);
            $table->string('template')->nullable();
            $table->string('contoh')->nullable();
            $table->string('shortlink');
            $table->string('kolaborator')->nullable();
            $table->text('keterangan_pemohon')->nullable();
            $table->string('nama_operator', 100)->nullable();
            $table->string('tautan_form')->nullable();
            $table->enum('status',['diajukan', 'diproses', 'ready'])->default('diajukan');
            $table->enum('is_deleted',['0', '1'])->default('0');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_form');
    }
};