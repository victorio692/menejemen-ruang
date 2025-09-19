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
        Schema::create('jadwal_regulers', function (Blueprint $table) {
            $table->id('id_reguler');
            $table->string('nama_reguler');
            $table->unsignedBigInteger('id_room');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            // Relasi ke tabel rooms
            $table->foreign('id_room')->references('id')->on('rooms')->onDelete('cascade');

            // Relasi ke tabel users
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_regulers');
    }
};
