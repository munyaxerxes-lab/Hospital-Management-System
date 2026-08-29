<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('order_items', function (Blueprint $table) {
                // Drop existing foreign key safely
                try {
                    $table->dropForeign('order_items_medicine_id_foreign');
                } catch (\Exception $e) {
                    // Ignore if not exists
                }
            });

            Schema::table('order_items', function (Blueprint $table) {
                try {
                    $table->foreign('medicine_id')->references('id')->on('medicine')->onDelete('cascade');
                } catch (\Exception $e) {
                    // Ignore if already set
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('order_items', function (Blueprint $table) {
                try {
                    $table->dropForeign(['medicine_id']);
                } catch (\Exception $e) {
                    // Ignore
                }
            });
        }
    }
};
