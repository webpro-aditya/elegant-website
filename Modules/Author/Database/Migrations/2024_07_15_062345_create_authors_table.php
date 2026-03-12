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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->nullable()->index();
            $table->string('facebook')->nullable()->index();
            $table->string('twitter')->nullable()->index();
            $table->string('instagram')->nullable()->index();
            $table->string('slug')->unique();
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
        Schema::dropIfExists('authors');
    }
};
