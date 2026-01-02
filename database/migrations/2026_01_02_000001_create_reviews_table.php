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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('handyman_id');
            $table->foreign('handyman_id')->references('handyman_id')->on('handyman')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->comment('1-5 stars');
            $table->text('comment')->nullable();
            $table->text('response')->nullable()->comment('Handyman response to review');
            $table->timestamp('response_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('handyman_id');
            $table->index('client_id');
            $table->index('rating');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
