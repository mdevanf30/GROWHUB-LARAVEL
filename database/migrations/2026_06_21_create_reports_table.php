<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('report_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('reporter_id'); // User yang melapor
            $table->unsignedInteger('reported_user_id'); // User yang dilaporkan
            $table->enum('report_type', ['umkm', 'freelancer']); // Tipe yang dilaporkan
            $table->enum('reason', [
                'penipuan_fraud',
                'pekerjaan_tidak_sesuai',
                'tidak_profesional',
                'komunikasi_buruk',
                'pelanggaran_ketentuan',
                'lainnya'
            ]);
            $table->text('details')->nullable();
            $table->enum('status', ['open', 'in_review', 'resolved', 'rejected'])->default('open');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('project_id')->references('project_id')->on('project')->onDelete('cascade');
            $table->foreign('reporter_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('reported_user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
