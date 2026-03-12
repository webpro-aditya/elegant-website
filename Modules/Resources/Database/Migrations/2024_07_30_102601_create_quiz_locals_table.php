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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->integer('resource_id')->nullable()->index();
            $table->enum('status', ['active', 'inactive'])->index();
            $table->integer('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quiz_locals', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id')->nullable()->index();
            $table->integer('language_id')->nullable()->index();
            $table->string('question')->nullable()->index();
            $table->json('options')->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('quiz_locals');
    }
};
