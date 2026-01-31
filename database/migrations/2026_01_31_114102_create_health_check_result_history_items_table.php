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
        Schema::create('health_check_result_history_items', function (Blueprint $table) {
            $table->id();            $table->string('check_name')->nullable();
            $table->string('check_label')->nullable();
            $table->string('status')->nullable();
            $table->text('notification_message')->nullable();
            $table->string('short_summary')->nullable();
            $table->longText('meta')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->char('batch')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_check_result_history_items');
    }
};
