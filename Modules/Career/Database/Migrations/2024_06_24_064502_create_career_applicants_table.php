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
        Schema::create('career_applicants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('career_id');
            $table->string('name')->index()->nullable();
            $table->string('email')->index()->nullable();
            $table->string('phone')->index()->nullable();
            $table->longText('linkedin_profile')->nullable();
            $table->string('job_profile')->nullable();
            $table->string('resume')->index()->nullable();
            $table->enum('status', ['active', 'inactive'])->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_applicants');
    }
};
