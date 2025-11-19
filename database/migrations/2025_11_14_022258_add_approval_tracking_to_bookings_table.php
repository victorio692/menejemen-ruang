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
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->comment('Waktu approval/rejection');
            $table->string('approved_by')->nullable()->comment('User yang approve/reject');
            $table->text('rejection_reason')->nullable()->comment('Alasan penolakan jika ditolak');
            $table->softDeletes(); // Untuk soft delete, history booking tetap tersimpan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['approved_at', 'approved_by', 'rejection_reason']);
            $table->dropSoftDeletes();
        });
    }
};
