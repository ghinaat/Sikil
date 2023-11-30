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
        Schema::create('pengajuan_blastemail', function (Blueprint $table) {
            $table->increments('id_pengajuan_blastemail');
            $table->unsignedInteger('id_users');
            $table->date('tgl_pengajuan');
            $table->enum('jenis_blast', ['Sertifikat Kegiatan', 'Surat Undangan', 'Informasi Lainnya']);
            $table->string('nama_kegiatan', 100);
            $table->text('keterangan_pemohon');
            $table->string('lampiran',255);
            $table->enum('nama_operator', [ 'Hana', 'Bayu', 'Wendy', 'Siswa Magang',  'Lainnya'])->nullable(); 
            $table->date('tgl_kirim')->nullable();
            $table->text('keterangan_operator')->nullable();
            $table->enum('status', [ 'diajukan', 'selesai'])->default('diajukan');  
            $table->foreign('id_users')->references('id_users')->on('users');       
            $table->enum('is_deleted', ['0', '1'])->default('0');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_blastemail');
    }
};