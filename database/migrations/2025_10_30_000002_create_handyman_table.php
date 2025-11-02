<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandymanTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('handyman')) {
            Schema::create('handyman', function (Blueprint $table) {
                // match users.userid (bigIncrements)
                $table->unsignedBigInteger('handyman_id')->primary();
                $table->text('services')->nullable();
                $table->text('bio')->nullable();
                $table->foreign('handyman_id')->references('id')->on('users')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('handyman');
    }
}
