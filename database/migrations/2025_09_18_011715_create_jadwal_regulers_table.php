<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_regulers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id'); // relasi ke rooms.id
            $table->string('hari'); // Senin, Selasa, dst
            $table->time('start_time');
            $table->time('end_time');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_regulers');
    }
};
