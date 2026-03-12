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
        if (!Schema::hasTable('training_calendars')) {
            Schema::create('training_calendars', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->unsignedBigInteger('course_id')->nullable();
                $table->unsignedBigInteger('batch_id')->default('0');
                $table->unsignedBigInteger('venue_id')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->enum('status', ['active', 'inactive', 'outdate'])->default('active');
                $table->timestamps();
                $table->softDeletes();
                // $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                // $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
                // $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('training_calendars')) {
            Schema::dropIfExists('training_calendars');
        }
    }
};
