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
        Schema::create('pengalaman_kerja', function (Blueprint $table) {
            $table->increments('id_pengalaman_kerja');
            $table->string('nama_perusahaan', 100);
            $table->string('masa_kerja', 20);
            $table->string('file_kerja', 255)->nullable();
            $table->string('posisi', 255);
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
        Schema::dropIfExists('pengalaman_kerja');
    }
};
