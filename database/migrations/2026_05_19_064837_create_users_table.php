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
       Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('full_name', 100);
            $table->date('birth_date')->nullable();
            $table->string('email_address', 100)->nullable();
            $table->text('home_address')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->string('password', 255);
            $table->decimal('rating', 2, 1)->nullable();
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
