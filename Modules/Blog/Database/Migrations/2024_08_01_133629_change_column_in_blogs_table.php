<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasColumn('blogs', 'author')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropIndex(['author']);
                $table->renameColumn('author', 'author_id');
            });
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('blogs', 'author_id')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->renameColumn('author_id', 'author');
                $table->index('author');
            });
        }
    }
};
