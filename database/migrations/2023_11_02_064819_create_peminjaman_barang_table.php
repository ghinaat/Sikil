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
        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->increments('id_peminjaman');
            $table->unsignedInteger('id_users');
            $table->date('tgl_ajuan');
            $table->date('tgl_peminjaman');
            $table->date('tgl_pengembalian');
            $table->string('kegiatan');
            $table->enum('status', ['belum_diajukan' ,'diajukan' ,'dipinjam', 'dikembalikan', 'dikembalikan_sebagian']);
            $table->string('keterangan');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barang');
    }
};