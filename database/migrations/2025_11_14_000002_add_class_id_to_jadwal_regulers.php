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
        Schema::table('jadwal_regulers', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_regulers', 'class_id')) {
                $table->unsignedBigInteger('class_id')->nullable()->after('room_id');
                $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_regulers', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_regulers', 'class_id')) {
                $table->dropForeign(['class_id']);
                $table->dropColumn('class_id');
            }
        });
    }
};
