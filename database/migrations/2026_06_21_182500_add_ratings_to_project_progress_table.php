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
        Schema::table('project_progress', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating_for_freelancer')->nullable()->after('payment_status');
            $table->unsignedTinyInteger('rating_for_umkm')->nullable()->after('rating_for_freelancer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_progress', function (Blueprint $table) {
            $table->dropColumn(['rating_for_freelancer', 'rating_for_umkm']);
        });
    }
};
