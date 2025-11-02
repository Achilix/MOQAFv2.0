<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'fname')) {
                $table->string('fname')->nullable();
            }
            if (!Schema::hasColumn('users', 'lname')) {
                $table->string('lname')->nullable();
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->enum('user_type', ['buyer', 'seller'])->nullable();
            }
            if (!Schema::hasColumn('users', 'gov_id')) {
                $table->string('gov_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumnIfExists(['fname', 'lname', 'phone_number', 'user_type', 'gov_id', 'address', 'city', 'photo']);
        });
    }
}
