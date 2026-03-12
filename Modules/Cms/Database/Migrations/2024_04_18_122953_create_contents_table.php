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
        if (!Schema::hasTable('contents')) {
            Schema::create('contents', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('content_category_id')->nullable()->index();
                $table->string('link')->nullable()->index();
                $table->string('file')->nullable()->index();
                $table->string('thumbnail')->nullable()->index();
                $table->string('slug')->index();
                $table->enum('status', ['active', 'inactive'])->index();
                $table->tinyInteger('is_deletable')->index()->default('1');
                $table->string('page_slug')->index();
                $table->enum('section', ['lms', 'web'])->index()->nullable();
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
        if (Schema::hasTable('contents')) {
            Schema::dropIfExists('contents');
        }
    }
};
