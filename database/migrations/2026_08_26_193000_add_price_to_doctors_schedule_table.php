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
        if (Schema::hasTable('doctors_schedule')) {
            Schema::table('doctors_schedule', function (Blueprint $table) {
                if (!Schema::hasColumn('doctors_schedule', 'price')) {
                    $table->decimal('price', 10, 2)->nullable()->after('end_time');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('doctors_schedule')) {
            Schema::table('doctors_schedule', function (Blueprint $table) {
                if (Schema::hasColumn('doctors_schedule', 'price')) {
                    $table->dropColumn('price');
                }
            });
        }
    }
};
