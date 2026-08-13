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
        //
        Schema::create("patient", function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()
            ->constrained()
            ->cascadeOnDelete();
        $table->string('gender')->nullable();
        $table->date('dob')->nullable();
        $table->string('address')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
