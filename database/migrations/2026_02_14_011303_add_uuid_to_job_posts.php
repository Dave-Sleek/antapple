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
        Schema::table('job_posts', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('job_posts', 'uuid')) {
                $table->uuid('uuid')->unique()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            // Drop the column if it exists
            if (Schema::hasColumn('job_posts', 'uuid')) {
                $table->dropColumn('uuid');
            }
        });
    }
};