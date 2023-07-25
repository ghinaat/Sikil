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
        Schema::create('profile_user', function (Blueprint $table) {
            $table->increments('id_profile_user');
            $table->string('nip', 20);
            $table->string('nik', 20);
            $table->string('kk', 20);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('alamat', 255);
            $table->string('no_hp', 20);
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu']);
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('pendidikan', 100);
            $table->date('tmt');
            $table->enum('status_kawin', ['menikah', 'belum_menikah']);
            $table->string('bpjs', 20);
            $table->unsignedInteger('id_jabatan');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('tb_jabatan')->onDelete('cascade');
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
        Schema::dropIfExists('profile');
    }
};