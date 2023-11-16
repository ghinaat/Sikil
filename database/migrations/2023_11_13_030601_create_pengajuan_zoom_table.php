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
        Schema::create('pengajuan_zoom', function (Blueprint $table) {
            $table->increments('id_pengajuan_zoom');
            $table->unsignedInteger('id_users');
            $table->date('tgl_pengajuan');
            $table->enum('jenis_zoom', ['meeting' ,'webinar']);
            $table->string('nama_kegiatan');
            $table->integer('jumlah_peserta');
            $table->date('tgl_pelaksanaan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('keterangan_pemohon')->nullable();
            $table->string('keterangan_operator')->nullable();
            $table->enum('nama_operator', [ 'Hana', 'Bayu', 'Wendy', 'Siswa Magang', 'Lainnya'])->nullable();;
            $table->enum('akun_zoom', ['ict.seaqil@gmail.com', 'training.qiteplanguage.org', 'seameoqil@gmail.com'])->nullable();
            $table->text('tautan_zoom')->nullable();
            $table->enum('status', ['diajukan','ready'])->nullable();
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
        Schema::dropIfExists('pengajuan_zoom');
    }
};
