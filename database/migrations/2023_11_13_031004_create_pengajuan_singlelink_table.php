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
        Schema::create('pengajuan_singlelink', function (Blueprint $table) {
            $table->increments('id_pengajuan_singlelink');
            $table->unsignedInteger('id_users');
            $table->date('tgl_pengajuan');
            $table->string('nama_kegiatan', 255);
            $table->string('nama_shortlink', 255);
            $table->string('keterangan_pemohon', 255)->nullable();
            $table->string('keterangan_operator', 255)->nullable();
            $table->enum('status', ['diajukan', 'ready']);
            $table->enum('is_deleted', ['0', '1'])->default('0');  
            $table->foreign('id_users')->references('id_users')->on('users');       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_singlelink');
    }
};
