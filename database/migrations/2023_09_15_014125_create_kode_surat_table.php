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
        Schema::create('kode_surat', function (Blueprint $table) {
            $table->increments('id_kode_surat');
            $table->string('divisi', 100);
            $table->string('kode_surat', 100);
            $table->enum('is_deleted', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_surat');
    }
};
