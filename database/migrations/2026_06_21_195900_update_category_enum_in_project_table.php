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
        // Altering enum column in Laravel is best done via raw SQL statement
        DB::statement("ALTER TABLE project MODIFY COLUMN category ENUM('Desain logo', 'Konten media sosial', 'Desain', 'Desain kemasan', 'Website', 'Desain Poster', 'Lain', 'Lainnya') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE project MODIFY COLUMN category ENUM('Desain logo', 'Konten media sosial', 'Desain', 'Lain') NOT NULL");
    }
};
