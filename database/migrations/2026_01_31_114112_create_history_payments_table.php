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
        Schema::create('history_payments', function (Blueprint $table) {
            $table->id();            $table->string('amount_paid')->nullable();
            $table->string('receipt_paid')->nullable();
            $table->string('date')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('paid_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_payments');
    }
};
