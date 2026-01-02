<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToClientTable extends Migration
{
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            if (!Schema::hasColumn('client', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            if (Schema::hasColumn('client', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}
