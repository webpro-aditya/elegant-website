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
        Schema::create('resource_content_locals', function (Blueprint $table) {
            $table->id();
            $table->integer('content_id')->nullable()->index();
            $table->integer('language_id')->nullable()->index();
            $table->string('question')->nullable()->index();
            $table->longText('answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_content_locals');
    }
};
