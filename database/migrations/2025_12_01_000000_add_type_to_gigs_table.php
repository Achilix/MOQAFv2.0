<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToGigsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('gigs')) {
            Schema::table('gigs', function (Blueprint $table) {
                if (!Schema::hasColumn('gigs', 'type')) {
                    $table->string('type')->nullable()->after('title');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('gigs')) {
            Schema::table('gigs', function (Blueprint $table) {
                if (Schema::hasColumn('gigs', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
}
