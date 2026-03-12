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
        Schema::create('free_resources', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['interview', 'quiz'])->index();
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable()->index();
            $table->enum('is_popular', ['yes', 'no'])->nullable()->index();
            $table->enum('section', ['lms', 'web'])->index()->nullable();
            $table->enum('status', ['active', 'inactive'])->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_resources');
    }
};
