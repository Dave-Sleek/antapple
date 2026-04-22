<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_clicks', function (Blueprint $table) {
            if (!Schema::hasColumn('job_clicks', 'clicked_at')) {
                $table->timestamp('clicked_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_clicks', function (Blueprint $table) {
            if (Schema::hasColumn('job_clicks', 'clicked_at')) {
                $table->dropColumn('clicked_at');
            }
        });
    }
};