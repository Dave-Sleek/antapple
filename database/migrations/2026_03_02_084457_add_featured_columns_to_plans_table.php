<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // $table->integer('featured_limit')->default(0)->after('featured_limit');
            $table->integer('feature_duration')->default(0)->after('featured_limit'); // days
        });
    }

    public function down(): void
    {
        // Schema::table('plans', function (Blueprint $table) {
        //     $table->dropColumn(['featured_limit', 'feature_duration']);
        // });
    }
};
