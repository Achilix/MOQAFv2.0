<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if conversations table exists
        if (Schema::hasTable('conversations')) {
            // Check if user1_id column doesn't exist
            if (!Schema::hasColumn('conversations', 'user1_id')) {
                Schema::table('conversations', function (Blueprint $table) {
                    $table->unsignedBigInteger('user1_id')->nullable();
                });
            }
            
            // Check if user2_id column doesn't exist
            if (!Schema::hasColumn('conversations', 'user2_id')) {
                Schema::table('conversations', function (Blueprint $table) {
                    $table->unsignedBigInteger('user2_id')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('conversations')) {
            Schema::table('conversations', function (Blueprint $table) {
                $table->dropColumn(['user1_id', 'user2_id']);
            });
        }
    }
};
