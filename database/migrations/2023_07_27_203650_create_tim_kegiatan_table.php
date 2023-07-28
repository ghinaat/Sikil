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
        Schema::create('tim_kegiatan', function (Blueprint $table) {
            $table->increments('id_tim');
            $table->unsignedInteger('id_kegiatan');
            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('tb_kegiatan')->onDelete('cascade');
            $table->unsignedInteger('id_pegawai');
            $table->foreign('id_pegawai')->references('id_users')->on('users') ->onDelete('cascade');
            $table->unsignedInteger('id_peran');
            $table->foreign('id_peran')->references('id_peran')->on('peran') ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_kegiatan');
    }
};