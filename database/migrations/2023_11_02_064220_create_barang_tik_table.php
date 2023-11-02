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
            $table->integer('kode_barang');
            $table->string('nama_barang');
            $table->string('merek');
            $table->string('kelengkapan');
            $table->date('tahun_pembelian');
            $table->enum('kondisi', ['Baik', 'Perlu Perbaikan', 'Rusak Total']);
            $table->enum('status_pinjam', ['Ya', 'Tidak']);
            $table->string('keterangan');
            $table->string('image');
            $table->enum('id_deleted', ['0', '1']);
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