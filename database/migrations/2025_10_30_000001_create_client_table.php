<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('client')) {
            Schema::create('client', function (Blueprint $table) {
                // match users.userid (bigIncrements)
                $table->unsignedBigInteger('client_id')->primary();
                $table->decimal('rating', 3, 2)->nullable();
                // reference users.id instead of userid
                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            });

            // add CHECK constraint for rating
            DB::statement('ALTER TABLE client ADD CONSTRAINT client_rating_check CHECK (rating >= 0 AND rating <= 5)');
        }
    }

    public function down()
    {
        Schema::dropIfExists('client');
    }
}
