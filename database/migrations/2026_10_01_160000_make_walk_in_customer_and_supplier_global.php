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
        // 1. Ensure Walk-in Customer (ID 1) has branch_id = NULL (global for all branches)
        $walkInCustomer = DB::table('customers')
            ->where('id', 1)
            ->orWhere('name', 'Walk-in Customer')
            ->orWhere('name', 'Walking Customer')
            ->orWhere('phone', '0000000000')
            ->first();

        if ($walkInCustomer) {
            DB::table('customers')->where('id', $walkInCustomer->id)->update([
                'branch_id' => null,
                'name' => 'Walk-in Customer',
                'status' => '1',
            ]);
        } else {
            DB::table('customers')->insert([
                'id' => 1,
                'date' => now()->toDateString(),
                'branch_id' => null,
                'name' => 'Walk-in Customer',
                'phone' => '0000000000',
                'due_amount' => 0.00,
                'total_point' => 0.00,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Ensure Walk-in Supplier (ID 1) has branch_id = NULL (global for all branches)
        $walkInSupplier = DB::table('suppliers')
            ->where('id', 1)
            ->orWhere('name', 'Walk-in Supplier')
            ->orWhere('name', 'Walking Supplier')
            ->orWhere('phone', '0000000000')
            ->first();

        if ($walkInSupplier) {
            DB::table('suppliers')->where('id', $walkInSupplier->id)->update([
                'branch_id' => null,
                'name' => 'Walk-in Supplier',
                'status' => '1',
            ]);
        } else {
            DB::table('suppliers')->insert([
                'id' => 1,
                'date' => now()->toDateString(),
                'branch_id' => null,
                'name' => 'Walk-in Supplier',
                'phone' => '0000000000',
                'advance_amount' => 0.00,
                'due_amount' => 0.00,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
