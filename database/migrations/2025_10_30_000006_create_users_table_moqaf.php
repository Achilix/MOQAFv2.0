<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTableMoqaf extends Migration
{
    public function up()
    {
        // OPTIONAL: create the database (requires connecting to a superuser DB and proper privileges).
        // Not recommended in normal migrations. Uncomment and adjust only if you know what you're doing:
        // DB::statement("CREATE DATABASE \"MOQAFDB\" WITH ENCODING='UTF8' LC_COLLATE='en_US.utf8' LC_CTYPE='en_US.utf8' TEMPLATE=template0;");

        // create table only if it doesn't already exist
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('userid'); // SERIAL / bigserial primary key
                $table->string('fname', 100);
                $table->string('lname', 100);
                $table->string('address', 255)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('phone_number', 30)->nullable();
                $table->string('gov_id', 100)->nullable();
                $table->string('photo', 255)->nullable();
                $table->string('email', 255)->unique();
                $table->string('password_hash', 255);
                $table->timestampTz('created_at')->useCurrent();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
