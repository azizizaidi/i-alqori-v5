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
        Schema::create('fee_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_names_id')->nullable();
            $table->string('total_hours_min')->nullable();
            $table->string('total_hours_max')->nullable();
            $table->string('feeperhour')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_rates');
    }
};
