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
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')
                      ->constrained('patient')
                      ->cascadeOnDelete();
                $table->foreignId('doctor_id')
                      ->constrained('doctors')
                      ->cascadeOnDelete();
                $table->foreignId('schedule_id')
                      ->nullable()
                      ->constrained('doctor_schedule')
                      ->nullOnDelete();
                $table->foreignId('payment_id')
                      ->nullable()
                      ->constrained('payments')
                      ->nullOnDelete();
                $table->text('reason')->nullable();
                $table->string('status')->default('confirmed');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id')->nullable();
                $table->unsignedBigInteger('doctor_id')->nullable();
                $table->unsignedBigInteger('appointment_id')->nullable();
                $table->string('title');
                $table->text('message');
                $table->string('type')->default('consultation');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('appointments');
    }
};
