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
            $table->string('nip', 20)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('kk', 20)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu'])->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('pendidikan', 100)->nullable();
            $table->date('tmt')->nullable();
            $table->enum('status_kawin', ['menikah', 'belum_menikah'])->nullable();
            $table->string('bpjs', 20)->nullable();
            $table->unsignedInteger('id_users');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_jabatan')->nullable();
            $table->foreign('id_jabatan')->references('id_jabatan')->on('tb_jabatan')->onDelete('cascade')->nullable();
            $table->unsignedInteger('id_tingkat_pendidikan')->nullable();
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