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
        Schema::create('detail_peminjaman_barang', function (Blueprint $table) {
            $table->increments('id_detail_peminjaman');
            $table->unsignedInteger('id_peminjaman');
            $table->unsignedInteger('id_barang_tik');
            $table->string('keterangan_awal');
            $table->string('keterangan_akhir')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->enum('status', ['dipinjam','dikembalikan'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman_barang');
    }
};