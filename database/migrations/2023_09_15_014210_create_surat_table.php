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
        Schema::create('surat', function (Blueprint $table) {
            $table->increments('id_surat');

            $table->string('no_surat', 100);
            $table->enum('jenis_surat', ['nota_dinas', 'notula_rapat', 'sertifikat_kegiatan', 'sertifikat_magang', 'surat_keluar']);
            $table->integer('urutan');
            $table->date('tgl_surat');
            $table->string('keterangan', 100);
            $table->enum('bulan_kegiatan', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'])->nullable();
            $table->enum('status', ['0', '1']);

            $table->unsignedInteger('id_users');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');

            $table->unsignedInteger('id_kode_surat');
            $table->foreign('id_kode_surat')->references('id_kode_surat')->on('kode_surat')->onDelete('cascade');

            $table->enum('is_deleted', ['0', '1'])->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};