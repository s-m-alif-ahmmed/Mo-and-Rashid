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
        if (!Schema::hasTable('product_review_images')) {
            Schema::create('product_review_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('product_review_id')->nullable()->constrained()->cascadeOnDelete();
                $table->string('image')->nullable();
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
        Schema::dropIfExists('product_review_images');
    }
};
