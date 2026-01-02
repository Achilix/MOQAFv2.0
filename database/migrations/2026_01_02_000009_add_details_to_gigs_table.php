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
        Schema::table('gigs', function (Blueprint $table) {
            if (!Schema::hasColumn('gigs', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->after('description');
            }
            if (!Schema::hasColumn('gigs', 'duration')) {
                $table->string('duration', 100)->nullable()->after('price');
            }
            if (!Schema::hasColumn('gigs', 'location')) {
                $table->string('location', 255)->nullable()->after('duration');
            }
            if (!Schema::hasColumn('gigs', 'availability')) {
                $table->text('availability')->nullable()->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gigs', function (Blueprint $table) {
            $table->dropColumn(['price', 'duration', 'location', 'availability']);
        });
    }
};
