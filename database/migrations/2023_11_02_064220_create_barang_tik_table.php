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
        Schema::create('barang_tik', function (Blueprint $table) {
            $table->increments('id_barang_tik');
            $table->unsignedInteger('id_ruangan');
            $table->enum('jenis_aset',['BMN', 'Non-BMN']);
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('merek');
            $table->string('kelengkapan');
            $table->string('tahun_pembelian');
            $table->enum('kondisi', ['Baik', 'Perlu Perbaikan', 'Rusak Total']);
            $table->enum('status_pinjam', ['Ya', 'Tidak']);
            $table->string('keterangan');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_tik');
    }
};