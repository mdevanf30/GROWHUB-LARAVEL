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
        Schema::table('project_cancellations', function (Blueprint $table) {
            $table->enum('cancelled_by_type', ['umkm', 'freelancer'])->default('umkm')->after('cancelled_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_cancellations', function (Blueprint $table) {
            $table->dropColumn('cancelled_by_type');
        });
    }
};
