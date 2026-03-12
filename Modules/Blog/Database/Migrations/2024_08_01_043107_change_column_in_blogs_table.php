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
        Schema::table('blog_locales', function (Blueprint $table) {
            $table->dropIndex(['short_description']);
        });

        Schema::table('blog_locales', function (Blueprint $table) {
            $table->longText('short_description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_locales', function (Blueprint $table) {
            $table->index('short_description');
        });

        Schema::table('blog_locales', function (Blueprint $table) {
            $table->string('short_description')->change();
        });
    }
};
