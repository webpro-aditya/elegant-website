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
        Schema::create('career_locales', function (Blueprint $table) {
            $table->id();
            $table->integer('career_id')->nullable()->index();
            $table->integer('language_id')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('location')->nullable()->index();
            $table->json('skill')->nullable();
            $table->json('job_profile')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_locales');
    }
};
