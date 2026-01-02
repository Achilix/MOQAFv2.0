<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('conversations')) {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user1_id');
                $table->unsignedBigInteger('user2_id');
                $table->timestamps();

                $table->foreign('user1_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('user2_id')->references('id')->on('users')->onDelete('cascade');

                $table->index(['user1_id', 'user2_id']);
                $table->unique(['user1_id', 'user2_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
