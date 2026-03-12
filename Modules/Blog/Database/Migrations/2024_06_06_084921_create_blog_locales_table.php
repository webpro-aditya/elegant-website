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
        Schema::create('blog_locales', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_id')->nullable()->index();
            $table->integer('language_id')->nullable()->index();
            $table->string('title')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('short_description')->nullable()->index();
            $table->longText('content')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_locales');
    }
};
