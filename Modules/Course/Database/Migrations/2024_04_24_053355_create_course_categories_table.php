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
        if (!Schema::hasTable('course_categories')) {

            Schema::create('course_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable()->index();
                $table->string('slug')->nullable()->index();
                $table->longText('description')->nullable();
                $table->string('image')->nullable();
                $table->enum('section', ['lms', 'web'])->default('lms')->index()->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active')->index();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_categories');
    }
};
