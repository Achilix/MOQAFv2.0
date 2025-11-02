<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigsTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('gigs')) {
            Schema::create('gigs', function (Blueprint $table) {
                $table->bigIncrements('id_gig');
                $table->string('title', 200);
                $table->text('description')->nullable();
                $table->text('photos')->nullable(); // consider JSONB or separate photos table
                $table->timestampTz('created_at')->useCurrent();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('gigs');
    }
}
