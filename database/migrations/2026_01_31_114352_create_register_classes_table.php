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
        Schema::create('register_classes', function (Blueprint $table) {
            $table->id();            $table->string('code_class')->nullable();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->unsignedBigInteger('class_name_id')->nullable();
            $table->unsignedBigInteger('class_package_id')->nullable();
            $table->unsignedBigInteger('class_numer_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_classes');
    }
};
