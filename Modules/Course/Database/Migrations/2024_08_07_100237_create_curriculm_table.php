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
        Schema::create('curriculum', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('email')->index();
            $table->string('country_code')->nullable()->index();
            $table->string('phone')->index();
            $table->string('subject')->index()->nullable();
            $table->longText('message')->nullable();
            $table->integer('course_id')->nullable()->index();
            $table->enum('section', ['lms', 'web'])->default('lms')->index();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('type')->index();
            $table->integer('email_send')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum');
    }
};
