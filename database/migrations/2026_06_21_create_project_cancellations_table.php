<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_cancellations', function (Blueprint $table) {
            $table->increments('cancellation_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('cancelled_by'); // User yang membatalkan (UMKM)
            $table->text('reason'); // Alasan pembatalan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('project_id')->references('project_id')->on('project')->onDelete('cascade');
            $table->foreign('cancelled_by')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_cancellations');
    }
};
