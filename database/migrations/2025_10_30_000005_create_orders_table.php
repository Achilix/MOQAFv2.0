<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->bigIncrements('order_id');
                $table->unsignedBigInteger('id_client')->nullable();
                $table->unsignedBigInteger('id_handyman')->nullable();
                $table->unsignedBigInteger('id_gig')->nullable();
                $table->decimal('price', 10, 2);
                $table->text('description')->nullable();
                $table->decimal('rating', 3, 2)->nullable();
                $table->string('status', 50)->default('pending');
                $table->timestampTz('created_at')->useCurrent();

                $table->foreign('id_client')->references('client_id')->on('client')->onDelete('set null');
                $table->foreign('id_handyman')->references('handyman_id')->on('handyman')->onDelete('set null');
                $table->foreign('id_gig')->references('id_gig')->on('gigs')->onDelete('set null');
            });

            DB::statement('ALTER TABLE orders ADD CONSTRAINT orders_rating_check CHECK (rating >= 0 AND rating <= 5)');
        }
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
