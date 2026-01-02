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
        // Add soft deletes to gigs table
        Schema::table('gigs', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to handyman table
        Schema::table('handyman', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to conversations table
        Schema::table('conversations', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gigs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('handyman', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
