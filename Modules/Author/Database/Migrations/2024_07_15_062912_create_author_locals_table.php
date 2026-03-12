<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('author_locals', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->nullable()->index();
            $table->integer('language_id')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('short_description')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_locals');
    }
};
