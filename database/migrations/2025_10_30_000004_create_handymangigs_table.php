<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandymangigsTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('handymangigs')) {
            Schema::create('handymangigs', function (Blueprint $table) {
                $table->unsignedBigInteger('id_handyman');
                $table->unsignedBigInteger('id_gig');
                $table->primary(['id_handyman', 'id_gig']);
                $table->foreign('id_handyman')->references('handyman_id')->on('handyman')->onDelete('cascade');
                $table->foreign('id_gig')->references('id_gig')->on('gigs')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('handymangigs');
    }
}
