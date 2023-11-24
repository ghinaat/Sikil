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
        Schema::create('pengajuan_desain', function (Blueprint $table) {
            $table->increments('id_pengajuan_desain');
            $table->unsignedInteger('id_users');
            $table->date('tgl_pengajuan');
            $table->string('nama_kegiatan');
            $table->string('tempat_kegiatan');
            $table->date('tgl_kegiatan');
            $table->date('tgl_digunakan');
            $table->enum('jenis_desain',['Cover Petunjuk Teknis', 'Cover Laporan', 'Cover Dokumen Pedukung', 'Cover Materi', 'Nametag', 'Spanduk Indoor','Spanduk Outdoor', 'Sertifikat', 'Social Media Feeds', 'Web-banner','Lainnya']);
            $table->string('ukuran', 100)->nullable();
            $table->string('lampiran_pendukung')->nullable();
            $table->string('lampiran_qrcode')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->string('keterangan_pemohon')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('lampiran_desain')->nullable();
            $table->enum('status', ['diajukan', 'diproses', 'dicek_kadiv', 'disetujui_kadiv', 'revisi', 'selesai'])->default('diajukan');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->enum('is_deleted',['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_desain');
    }
};