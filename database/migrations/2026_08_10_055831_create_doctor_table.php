<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->string('doctor_name');

            $table->string('specialty');

            $table->string('qualification');

            $table->unsignedInteger('years_of_experience');

            $table->decimal('consultation_fee', 10, 2);

            $table->string('username')->unique();

            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};