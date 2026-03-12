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
        Schema::table('seo', function (Blueprint $table) {
            $table->longText('google_analytics_head')->after('model_id')->nullable();
            $table->longText('google_analytics_body')->after('model_id')->nullable();
            $table->longText('google_analytics_footer')->after('model_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seos', function (Blueprint $table) {
            $table->dropColumn('google_analytics_head');
            $table->dropColumn('google_analytics_body');
            $table->dropColumn('google_analytics_footer');
        });
    }
};
