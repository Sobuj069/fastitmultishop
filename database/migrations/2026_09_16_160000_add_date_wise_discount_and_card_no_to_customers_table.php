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
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'card_no')) {
                $table->string('card_no')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('customers', 'discount_type')) {
                $table->string('discount_type')->nullable()->default('percentage')->after('due_amount');
            }
            if (!Schema::hasColumn('customers', 'discount_value')) {
                $table->decimal('discount_value', 10, 2)->default(0)->nullable()->after('discount_type');
            }
            if (!Schema::hasColumn('customers', 'discount_start_date')) {
                $table->date('discount_start_date')->nullable()->after('discount_value');
            }
            if (!Schema::hasColumn('customers', 'discount_end_date')) {
                $table->date('discount_end_date')->nullable()->after('discount_start_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['card_no', 'discount_type', 'discount_value', 'discount_start_date', 'discount_end_date'] as $col) {
                if (Schema::hasColumn('customers', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
