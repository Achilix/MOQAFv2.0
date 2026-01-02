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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorite_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('favoritable_type', 50)->comment('Gig or Handyman');
            $table->unsignedBigInteger('favoritable_id');
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index(['favoritable_type', 'favoritable_id']);
            
            // Unique constraint - user can favorite an item only once
            $table->unique(['user_id', 'favoritable_type', 'favoritable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
