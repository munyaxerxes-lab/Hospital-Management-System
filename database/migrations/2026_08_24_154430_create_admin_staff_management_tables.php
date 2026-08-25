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
        // 1. Doctors Extensions Table (Links to primary users table)
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('specialization');
            $table->string('license_number')->unique();
            $table->string('department');
            $table->text('biography')->nullable();
            $table->decimal('consultation_fee', 8, 2)->default(0.00);
            $table->enum('status', ['active', 'on_leave', 'suspended'])->default('active');
            $table->timestamps();
        });

        // 2. Doctor Availability Schedules (Managed by Admin)
        Schema::create('doctor_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_patients_per_slot')->default(5);
            $table->timestamps();
        });

        // 3. Admin Audit Logs (Tracks which admin changed what staff record)
        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('action_performed'); // e.g., 'Added Doctor', 'Updated Schedule'
            $table->string('target_type');       // e.g., 'App\Models\Doctor'
            $table->unsignedBigInteger('target_id');
            $table->text('changes_made')->nullable(); // JSON or serialized string of edits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_audit_logs');
        Schema::dropIfExists('doctor_availabilities');
        Schema::dropIfExists('doctors');
    }
};
