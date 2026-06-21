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
        Schema::table('project_progress', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'pending', 'approved', 'rejected'])->default('unpaid')->after('payment_proof');
        });

        // Update existing records that already have payment proofs to 'approved'
        DB::table('project_progress')->whereNotNull('payment_proof')->update(['payment_status' => 'approved']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_progress', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });
    }
};
