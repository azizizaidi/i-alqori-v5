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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();            $table->string('student')->nullable();
            $table->string('registrar')->nullable();
            $table->string('teacher')->nullable();
            $table->string('class')->nullable();
            $table->string('total_hour')->nullable();
            $table->string('amount_fee')->nullable();
            $table->string('date_class')->nullable();
            $table->string('fee_perhour')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
