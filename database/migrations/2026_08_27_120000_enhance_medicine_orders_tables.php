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
        // 1. Ensure `medicine` table has all necessary attributes
        if (Schema::hasTable('medicine')) {
            Schema::table('medicine', function (Blueprint $table) {
                if (!Schema::hasColumn('medicine', 'type')) {
                    $table->string('type')->default('Tablets')->after('name');
                }
                if (!Schema::hasColumn('medicine', 'status')) {
                    $table->boolean('status')->default(true)->after('stock');
                }
                if (!Schema::hasColumn('medicine', 'expiry_date')) {
                    $table->date('expiry_date')->nullable()->after('status');
                }
                if (!Schema::hasColumn('medicine', 'image')) {
                    $table->string('image')->nullable()->after('price');
                }
            });
        }

        // 2. Ensure `orders` table has order_number, user_id, total_amount, status, payment details, delivered_at
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'order_number')) {
                    $table->string('order_number')->nullable()->unique()->after('id');
                }
                if (!Schema::hasColumn('orders', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('patient_id')->constrained('users')->nullOnDelete();
                }
                if (!Schema::hasColumn('orders', 'total_amount')) {
                    $table->decimal('total_amount', 10, 2)->default(0.00)->after('payment_id');
                }
                if (!Schema::hasColumn('orders', 'status')) {
                    $table->string('status')->default('pending')->after('total_amount'); // 'pending', 'delivered', 'processing', 'cancelled'
                }
                if (!Schema::hasColumn('orders', 'payment_status')) {
                    $table->string('payment_status')->default('pending')->after('status');
                }
                if (!Schema::hasColumn('orders', 'payment_method')) {
                    $table->string('payment_method')->default('cash_on_delivery')->after('payment_status');
                }
                if (!Schema::hasColumn('orders', 'shipping_address')) {
                    $table->text('shipping_address')->nullable()->after('payment_method');
                }
                if (!Schema::hasColumn('orders', 'notes')) {
                    $table->text('notes')->nullable()->after('shipping_address');
                }
                if (!Schema::hasColumn('orders', 'delivered_at')) {
                    $table->timestamp('delivered_at')->nullable()->after('notes');
                }
            });
        }

        // 3. Ensure `order_items` table has quantity, unit_price, total_price
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'quantity')) {
                    $table->integer('quantity')->default(1)->after('medicine_id');
                }
                if (!Schema::hasColumn('order_items', 'unit_price')) {
                    $table->decimal('unit_price', 10, 2)->default(0.00)->after('quantity');
                }
                if (!Schema::hasColumn('order_items', 'total_price')) {
                    $table->decimal('total_price', 10, 2)->default(0.00)->after('unit_price');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                $columns = ['quantity', 'unit_price', 'total_price'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('order_items', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'user_id')) {
                    $table->dropForeign(['user_id']);
                }
                $columns = ['order_number', 'user_id', 'total_amount', 'status', 'payment_status', 'payment_method', 'shipping_address', 'notes', 'delivered_at'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('orders', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('medicine')) {
            Schema::table('medicine', function (Blueprint $table) {
                $columns = ['type', 'status', 'expiry_date', 'image'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('medicine', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
