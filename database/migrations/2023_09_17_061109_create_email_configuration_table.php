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
        Schema::create('email_configuration', function (Blueprint $table) {
            $table->increments('id_email_configuration');

            $table->string('protocol');
            $table->string('host');
            $table->string('port');
            $table->string('timeout');
            $table->string('username');
            $table->string('email');
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_configuration');
    }
};
