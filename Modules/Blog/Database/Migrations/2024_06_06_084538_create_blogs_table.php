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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->nullable()->index();
            $table->integer('author_id')->nullable();
            $table->integer('category_id')->nullable()->index();
            $table->string('slug')->index();
            $table->enum('section', ['lms', 'web'])->index()->nullable();
            $table->enum('is_popular', ['yes', 'no'])->nullable()->index();
            $table->enum('career_guidance', ['yes', 'no'])->nullable()->index();
            $table->enum('status', ['active', 'inactive'])->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
