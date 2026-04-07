<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('subscription_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('reference')->unique();
            $table->string('provider'); // paystack, stripe

            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('NGN');

            $table->enum('status', [
                'pending',
                'successful',
                'failed',
                'refunded'
            ])->default('pending');

            $table->json('payload')->nullable(); // full webhook response

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
