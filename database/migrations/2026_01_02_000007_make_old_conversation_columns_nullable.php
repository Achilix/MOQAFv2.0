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
        if (Schema::hasTable('conversations')) {
            Schema::table('conversations', function (Blueprint $table) {
                // Make old columns nullable if they exist
                if (Schema::hasColumn('conversations', 'client_id')) {
                    $table->unsignedBigInteger('client_id')->nullable()->change();
                }
                if (Schema::hasColumn('conversations', 'handyman_id')) {
                    $table->unsignedBigInteger('handyman_id')->nullable()->change();
                }
                if (Schema::hasColumn('conversations', 'gig_id')) {
                    $table->unsignedBigInteger('gig_id')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('conversations')) {
            Schema::table('conversations', function (Blueprint $table) {
                if (Schema::hasColumn('conversations', 'client_id')) {
                    $table->unsignedBigInteger('client_id')->nullable(false)->change();
                }
                if (Schema::hasColumn('conversations', 'handyman_id')) {
                    $table->unsignedBigInteger('handyman_id')->nullable(false)->change();
                }
                if (Schema::hasColumn('conversations', 'gig_id')) {
                    $table->unsignedBigInteger('gig_id')->nullable(false)->change();
                }
            });
        }
    }
};
