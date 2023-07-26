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
        Schema::create('diklat', function (Blueprint $table) {
            $table->increments('id_diklat');
            $table->string('jenis_diklat', 20);
            $table->string('nama_siklat', 100);
            $table->string('penyelenggara', 100);
            $table->date('tanggal_diklat');
            $table->integer('jp',);
            $table->string('file_sertifikat', 255);
            $table->unsignedInteger('id_users');
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
        Schema::dropIfExists('diklat');
    }
};