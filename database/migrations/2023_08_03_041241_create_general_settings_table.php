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
        Schema::create('general_setting', function (Blueprint $table) {
        $table->increments('id_general');
        $table->enum('tahun_aktif', ['2020', '2021', '2022', '2023', '2024', '2025']);
        $table->unsignedInteger('id_users');
        $table->enum('status', ['0', '1']);
        $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};