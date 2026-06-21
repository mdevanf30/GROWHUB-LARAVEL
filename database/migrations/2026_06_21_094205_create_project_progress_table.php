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
        Schema::create('project_progress', function (Blueprint $table) {
            $table->increments('progress_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('freelancer_id');
            $table->enum('current_stage', ['planning', 'executing', 'monitoring', 'testing', 'finish'])->default('planning');
            $table->string('project_link', 255)->nullable();
            $table->string('project_file', 255)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('project')->onDelete('cascade');
            $table->foreign('freelancer_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_progress');
    }
};
