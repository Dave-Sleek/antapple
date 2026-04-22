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
        // For MySQL
        DB::statement("ALTER TABLE job_posts MODIFY COLUMN status ENUM('active', 'expired', 'pending', 'inactive', 'rejected', 'draft') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'draft' from enum
        DB::statement("ALTER TABLE job_posts MODIFY COLUMN status ENUM('active', 'expired', 'pending', 'inactive', 'rejected') DEFAULT 'pending'");
    }
};