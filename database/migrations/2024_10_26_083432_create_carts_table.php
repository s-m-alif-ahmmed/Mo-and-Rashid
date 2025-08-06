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
        if (!Schema::hasTable('carts')) {
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('color_id')->nullable();
                $table->unsignedBigInteger('size_id')->nullable();
                $table->decimal('selling_price', 10, 2);
                $table->decimal('discount_price', 10, 2)->nullable();
                $table->integer('quantity')->default(1);
                $table->timestamps();
                $table->softDeletes();

                //foriegn keys
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
                $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
