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
        if (Schema::hasTable('doctor_schedule')) {
            Schema::table('doctor_schedule', function (Blueprint $table) {
                if (!Schema::hasColumn('doctor_schedule', 'price')) {
                    $table->decimal('price', 10, 2)->default(0.00)->after('end_time');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('doctor_schedule')) {
            Schema::table('doctor_schedule', function (Blueprint $table) {
                if (Schema::hasColumn('doctor_schedule', 'price')) {
                    $table->dropColumn('price');
                }
            });
        }
    }
};
