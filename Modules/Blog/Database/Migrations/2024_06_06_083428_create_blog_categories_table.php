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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en')->nullable();
            $table->string('name_sp')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('slug')->unique();
            $table->enum('section', ['lms', 'web'])->index()->nullable();
            $table->enum('is_featured', ['yes', 'no'])->index()->default('no');
            $table->enum('career_guidance', ['yes', 'no'])->index()->default('no');
            $table->enum('status', ['active', 'inactive'])->index()->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
