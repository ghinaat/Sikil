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
        Schema::create('pengajuan_perbaikan', function (Blueprint $table) {
            $table->increments('id_pengajuan_perbaikan');
            $table->unsignedInteger('id_users');
            $table->date('tgl_pengajuan');
            $table->unsignedInteger('id_barang_tik');
            $table->text('keterangan_pemohon');
            $table->string('nama_operator', 100)->nullable();
            $table->text('keterangan_operator')->nullable();
            $table->date('tgl_pengecekan')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->enum('status', ['diajukan', 'diproses', 'selesai'])->default('diajukan');
            $table->enum('is_deleted',['0', '1'])->default('0');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->foreign('id_barang_tik')->references('id_barang_tik')->on('barang_tik')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_perbaikan');
    }
};