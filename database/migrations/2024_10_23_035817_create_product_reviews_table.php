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
        if (!Schema::hasTable('product_reviews')) {
            Schema::create('product_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
                $table->enum('rating', [1, 2, 3, 4, 5])->nullable();
                $table->string('title');
                $table->text('review');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active')->nullable();
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
        Schema::dropIfExists('product_reviews');
    }
};
