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
        Schema::table('training_calendars', function (Blueprint $table) {
            $table->dropColumn('venue_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_calendars', function (Blueprint $table) {
            $table->unsignedBigInteger('venue_id')->after('category_id')->nullable()->index();
        });
    }
};
