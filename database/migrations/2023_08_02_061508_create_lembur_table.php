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
        Schema::create('lembur', function (Blueprint $table) {
            $table->increments('id_lembur');
            $table->unsignedInteger('kode_finger');
            $table->unsignedInteger('id_atasan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->time('jam_lembur');
            $table->string('tugas', 255);
            $table->enum('status_izin_atasan', ['0','1'])->nullable()->default(null);
            $table->foreign('kode_finger')->references('kode_finger')->on('users')->onDelete('cascade');
            $table->foreign('id_atasan')->references('id_users')->on('users')->onDelete('cascade');
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembur');
    }
};
