<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('route_statistics', function (Blueprint $table) {
            $table->id();            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('method')->nullable();
            $table->string('route')->nullable();
            $table->integer('status')->nullable();
            $table->string('ip')->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('counter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_statistics');
    }
};
