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
        Schema::create('user_user_alert', function (Blueprint $table) {
            $table->id();            $table->unsignedBigInteger('user_alert_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('read')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_user_alert');
    }
};
