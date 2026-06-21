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
        Schema::create('project_applicants', function (Blueprint $table) {
            $table->increments('application_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('user_id');
            $table->text('cover_letter')->nullable();
            $table->string('portfolio_file')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('decided_at')->nullable();

            $table->foreign('project_id')->references('project_id')->on('project')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            // Unique constraint agar satu freelancer tidak bisa melamar project yang sama 2x
            $table->unique(['project_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_applicants');
    }
};
