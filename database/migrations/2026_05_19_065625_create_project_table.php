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
        Schema::create('project', function (Blueprint $table) {
            $table->increments('project_id');
            $table->unsignedInteger('umkm_id');
            $table->string('project_title', 200);
            $table->enum('category', ['Desain logo', 'Konten media sosial', 'Desain', 'Lain']);
            $table->text('description');
            $table->decimal('project_budget', 12, 2);
            $table->date('deadline');
            $table->string('project_address', 150)->nullable();
            $table->text('requirements')->nullable();
            $table->string('reference_file', 255)->nullable();
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('umkm_id')->references('umkm_id')->on('umkm')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
