<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();

            // Unique identifier
            $table->uuid('uuid')->unique();

            // Optional owner (for internships / programs by companies)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Core info
            $table->string('title');
            $table->string('slug');

            // Type of opportunity
            $table->enum('type', [
                'internship',
                'scholarship',
                'grant',
                'graduate_program'
            ]);

            // Organization / Provider
            $table->string('organization')->nullable();

            // Content
            $table->longText('description')->nullable();

            // Location
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);

            // Financial info
            $table->string('salary_range')->nullable(); // internships
            $table->string('funding_type')->nullable(); // scholarships/grants

            // Deadline
            $table->date('deadline')->nullable();

            // External application link
            $table->string('apply_url')->nullable();

            // Thumbnail / image (optional)
            $table->string('image')->nullable();

            // Status & visibility
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);

            // Featured system (same logic as jobs)
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};