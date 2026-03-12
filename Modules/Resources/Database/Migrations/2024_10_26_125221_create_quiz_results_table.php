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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->integer('resource_id')->index()->nullable();
            $table->string('name', 100)->index()->nullable();
            $table->string('email', 100)->index()->nullable();
            $table->json('result')->nullable();
            $table->integer('score')->index()->nullable();
            $table->integer('attempts_done')->index()->nullable();
            $table->time('time_taken')->nullable();
            $table->integer('accuracy')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
