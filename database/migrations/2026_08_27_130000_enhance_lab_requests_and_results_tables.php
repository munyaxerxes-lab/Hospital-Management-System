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
        // 1. Enhance lab_reqests table
        Schema::table('lab_reqests', function (Blueprint $table) {
            if (!Schema::hasColumn('lab_reqests', 'request_number')) {
                $table->string('request_number')->nullable()->after('id');
            }
            if (!Schema::hasColumn('lab_reqests', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('request_number')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('lab_reqests', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0.00)->after('payment_id');
            }
            if (!Schema::hasColumn('lab_reqests', 'status')) {
                $table->string('status')->default('pending')->after('total_amount');
            }
            if (!Schema::hasColumn('lab_reqests', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            if (!Schema::hasColumn('lab_reqests', 'payment_method')) {
                $table->string('payment_method')->default('cash_on_delivery')->after('payment_status');
            }
            if (!Schema::hasColumn('lab_reqests', 'sample_type')) {
                $table->string('sample_type')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('lab_reqests', 'scheduled_date')) {
                $table->date('scheduled_date')->nullable()->after('sample_type');
            }
            if (!Schema::hasColumn('lab_reqests', 'scheduled_time')) {
                $table->string('scheduled_time')->nullable()->after('scheduled_date');
            }
            if (!Schema::hasColumn('lab_reqests', 'address')) {
                $table->text('address')->nullable()->after('scheduled_time');
            }
            if (!Schema::hasColumn('lab_reqests', 'notes')) {
                $table->text('notes')->nullable()->after('address');
            }
            if (!Schema::hasColumn('lab_reqests', 'result_document')) {
                $table->string('result_document')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('lab_reqests', 'result_file_name')) {
                $table->string('result_file_name')->nullable()->after('result_document');
            }
            if (!Schema::hasColumn('lab_reqests', 'result_file_type')) {
                $table->string('result_file_type')->nullable()->after('result_file_name');
            }
            if (!Schema::hasColumn('lab_reqests', 'result_notes')) {
                $table->text('result_notes')->nullable()->after('result_file_type');
            }
            if (!Schema::hasColumn('lab_reqests', 'result_uploaded_at')) {
                $table->timestamp('result_uploaded_at')->nullable()->after('result_notes');
            }
            if (!Schema::hasColumn('lab_reqests', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('result_uploaded_at');
            }
        });

        // 2. Create lab_request_items table if it doesn't exist
        if (!Schema::hasTable('lab_request_items')) {
            Schema::create('lab_request_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lab_request_id')->constrained('lab_reqests')->cascadeOnDelete();
                $table->foreignId('lab_test_id')->constrained('lab_tests')->cascadeOnDelete();
                $table->string('test_name')->nullable();
                $table->decimal('price', 10, 2)->default(0.00);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_request_items');

        Schema::table('lab_reqests', function (Blueprint $table) {
            $columns = [
                'request_number', 'user_id', 'total_amount', 'status',
                'payment_status', 'payment_method', 'sample_type',
                'scheduled_date', 'scheduled_time', 'address', 'notes',
                'result_document', 'result_file_name', 'result_file_type',
                'result_notes', 'result_uploaded_at', 'delivered_at'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('lab_reqests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
