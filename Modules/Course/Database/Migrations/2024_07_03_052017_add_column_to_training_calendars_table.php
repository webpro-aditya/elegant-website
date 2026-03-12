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
        Schema::table('training_calendars', function (Blueprint $table) {
            $table->json('days')->nullable()->after('end_date');
            $table->time('start_time')->nullable()->after('end_date');
            $table->text('end_time')->nullable()->after('end_date');
            $table->dropColumn('title');
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_calendars', function (Blueprint $table) {
            $table->dropColumn('days');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->string('title')->nullable()->after('id');
        });
    }
};
