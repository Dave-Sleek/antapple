<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('company_name');
            $table->string('company_logo')->nullable();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('job_type', [
                'full-time',
                'part-time',
                'contract',
                'internship',
                'temporary'
            ]);

            $table->string('location'); // Remote / Lagos / Abuja / Global
            $table->enum('experience_level', ['entry', 'mid', 'senior'])->nullable();

            $table->string('salary_range')->nullable();

            $table->text('short_description');

            $table->string('apply_url'); // official company link

            $table->date('deadline')->nullable();

            $table->boolean('is_featured')->default(false);

            $table->enum('status', ['active', 'expired'])->default('active');

            $table->string('source')->nullable(); // LinkedIn, Company site, etc.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
