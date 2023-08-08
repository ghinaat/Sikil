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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->increments('id_keluarga');
            $table->string('nama', 100);
            $table->date('tanggal_lahir');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->enum('status', ['hidup', 'meninggal']);
            $table->unsignedInteger('id_users');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->unsignedInteger('id_hubungan');
            $table->foreign('id_hubungan')->references('id_hubungan')->on('hubungan_keluarga')->onDelete('cascade');
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};
