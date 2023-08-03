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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_users');
            $table->string('nama_pegawai',100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('_password_');
            $table->unsignedInteger('id_jabatan')->nullable();
            $table->enum('level', ['admin', 'kadiv', 'dda','ddo', 'staf']);
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan')->onDelete('cascade');
            $table->unsignedInteger('kode_finger')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};