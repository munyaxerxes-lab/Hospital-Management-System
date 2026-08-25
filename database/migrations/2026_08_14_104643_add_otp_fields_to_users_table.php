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
        // Only modify the table if the columns do not already exist
        if (!Schema::hasColumn('users', 'otp_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('otp_code', 6)->nullable();
                $table->timestamp('otp_expires_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop the columns if they actually exist to prevent rollback errors
            if (Schema::hasColumn('users', 'otp_code')) {
                $table->dropColumn(['otp_code', 'otp_expires_at']);
            }
        });
    }
};
