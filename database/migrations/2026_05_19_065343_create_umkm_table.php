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
        Schema::create('umkm', function (Blueprint $table) {
            $table->increments('umkm_id');
            $table->unsignedInteger('user_id');
            $table->string('business_name', 150);
            $table->text('description')->nullable();
            $table->string('supporting_file', 255)->nullable();
            $table->enum('category', ['kuliner', 'fashion', 'teknologi', 'jasa', 'lain']);
            $table->string('address', 255);
            $table->string('phone_number', 20)->nullable();
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
