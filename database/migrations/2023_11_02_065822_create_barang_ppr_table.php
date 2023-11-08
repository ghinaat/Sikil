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
        Schema::create('barang_ppr', function (Blueprint $table) {
            $table->increments('id_barang_ppr');
            $table->unsignedInteger('id_ruangan');
            $table->string('nama_barang', 255);
            $table->string('tahun_pembuatan', 4);
            $table->integer('jumlah');
            $table->string('keterangan', 255);
            $table->string('image', 255)->nullable();
            $table->enum('is_deleted', ['0', '1'])->default('0');         
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_ppr');
    }
};
