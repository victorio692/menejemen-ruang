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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('id_schedule');
            $table->unsignedBigInteger('id_room');
            $table->date('tanggal'); // untuk insidental
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('hari')->nullable(); // untuk jadwal tetap (misalnya: Senin, Selasa)
            $table->string('kegiatan')->nullable();
            $table->timestamps();

            // Relasi ke tabel rooms
            $table->foreign('id_room')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
