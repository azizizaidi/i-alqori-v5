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
        Schema::create('report_classes', function (Blueprint $table) {
            $table->id();
            $table->mediumText('date');
            $table->string('total_hour', 100);
            $table->string('month')->nullable();
            $table->integer('allowance')->nullable();
            $table->unsignedBigInteger('registrar_id')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('class_names_id')->nullable();
            $table->mediumText('date_2')->nullable();
            $table->string('total_hour_2', 100)->nullable();
            $table->unsignedBigInteger('class_names_id_2')->nullable();
            $table->string('fee_student', 250)->nullable();
            $table->integer('status')->nullable();
            $table->string('note')->nullable();
            $table->string('receipt')->nullable();
            $table->string('allowance_note', 250)->nullable();
            $table->string('transaction_time', 256)->nullable();
            $table->string('bill_code', 256)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_classes');
    }
};
