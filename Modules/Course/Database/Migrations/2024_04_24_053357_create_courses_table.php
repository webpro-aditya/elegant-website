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
        if (!Schema::hasTable('courses')) {

            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('section');
                $table->string('slug')->unique();
                $table->string('code')->unique();
                $table->unsignedBigInteger('category_id');
                $table->enum('mode_of_learning', ['online', 'offline', 'self-paced']);
                $table->date('start_date')->nullable();
                $table->enum('duration_type', ['days', 'months']);
                $table->integer('duration')->nullable();
                $table->decimal('fee', 8, 2)->nullable();
                $table->string('thumbnail_url')->nullable();
                $table->string('demo_video_url')->nullable();
                $table->string('brochure_url')->nullable();
                $table->string('curriculum_url')->nullable();
                $table->enum('status', ['publish', 'draft', 'suspend', 'outdate'])->default('draft');
                $table->enum('started', ['yes', 'no'])->default('no');
                $table->boolean('featured')->default(false);
                $table->enum('pricing_format', ['free', 'paid'])->default('free');

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
