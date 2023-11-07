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
        Schema::create('sirkulasi_barang', function (Blueprint $table) {
            $table->increments('id_sirkulasi_barang');
            $table->unsignedInteger('id_barang_ppr');
            $table->unsignedInteger('id_users');
            $table->date('tgl_sirkulasi');
            $table->integer('jumlah');
            $table->enum('jenis_sirkulasi', ['penambahan', 'pengurangan']);
            $table->string('keterangan');
            $table->enum('is_deleted', ['0', '1'])->default('0');  
            $table->foreign('id_users')->references('id_users')->on('users');       
            $table->foreign('id_barang_ppr')->references('id_barang_ppr')->on('barang_ppr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sirkulasi_barang');
    }
};