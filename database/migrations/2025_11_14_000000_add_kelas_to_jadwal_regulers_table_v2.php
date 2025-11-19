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
            if (!Schema::hasColumn('jadwal_regulers', 'kelas')) {
                $table->string('kelas')->nullable()->after('hari');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_regulers', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_regulers', 'kelas')) {
                $table->dropColumn('kelas');
            }
        });
    }
};
