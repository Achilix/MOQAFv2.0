<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gig_tiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_gig');
            $table->enum('tier_name', ['BASIC', 'MEDIUM', 'PREMIUM'])->default('BASIC');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->integer('delivery_days')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_gig')->references('id_gig')->on('gigs')->onDelete('cascade');
            $table->unique(['id_gig', 'tier_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gig_tiers');
    }
};
