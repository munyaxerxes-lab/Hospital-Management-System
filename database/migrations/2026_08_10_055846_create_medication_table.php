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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('medicine_categories')
                ->OnDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->date('expiry_date')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->integer('stock')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
