<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE complaints MODIFY COLUMN status ENUM('pending','under_review','scheduled','resolved','rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE complaints MODIFY COLUMN status ENUM('pending','under_review','resolved','rejected') NOT NULL DEFAULT 'pending'");
    }
};