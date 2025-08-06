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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('country_id')->nullable()->constrained()->cascadeOnDelete();
                $table->string('name')->nullable();
                $table->string('address')->nullable();
                $table->string('apartment')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('contact')->nullable();
                $table->decimal('total', 10, 2)->nullable();
                $table->enum('status', ['Payment Failed','Pending Payment','Pending', 'Complete','Return','Canceled'])->default('Pending')->nullable();
                $table->enum('all_terms', ['0', '1'])->nullable();
                $table->string('tracking_id');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
