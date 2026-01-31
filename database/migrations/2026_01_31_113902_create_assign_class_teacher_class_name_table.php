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
        Schema::create('assign_class_teacher_class_name', function (Blueprint $table) {
            $table->id();            $table->unsignedBigInteger('assign_class_teacher_id')->nullable();
            $table->unsignedBigInteger('class_name_id')->nullable();
            $table->unsignedBigInteger('class_package_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_class_teacher_class_name');
    }
};
