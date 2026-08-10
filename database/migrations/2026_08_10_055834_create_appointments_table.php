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
        Schema::create('appointments', function (Blueprint $table) {
                    $table->id();
                    $table->string('reason')->nullable();
                    $table->string('status')->default('pending');
                    $table->timestamps();
                    $table->foreignId('patient_id')
            ->constrained('patient')
            ->cascadeOnDelete();

        $table->foreignId('doctor_id')
            ->constrained('doctor')
            ->cascadeOnDelete();

        $table->foreignId('schedule_id')
            ->constrained('doctors_schedule')
            ->cascadeOnDelete();

        $table->foreignId('payment_id')
            ->nullable()
            ->constrained('payments')
            ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
