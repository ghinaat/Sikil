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
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->increments('id_pendidikan');
            $table->string('nama_sekolah', 100);
            $table->string('jurusan', 100);
            $table->string('tahun_lulus', 20);
            $table->string('ijazah', 20);
            $table->unsignedInteger('id_users');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_tingkat_pendidikan');
            $table->foreign('id_tingkat_pendidikan')->references('id_tingkat_pendidikan')->on('tingkat_pendidikan')->onDelete('cascade');
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan');
    }
};
