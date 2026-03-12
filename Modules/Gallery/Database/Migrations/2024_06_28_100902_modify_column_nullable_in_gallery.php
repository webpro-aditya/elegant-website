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
        Schema::table('gallery', function (Blueprint $table) {
            // Change the column to be nullable
            $table->text('name_en')->nullable()->change();
            $table->text('name_sp')->nullable()->change();
            $table->text('name_ar')->nullable()->change();
            $table->text('name_fr')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->text('name_en')->nullable(false)->change();
            $table->text('name_sp')->nullable(false)->change();
            $table->text('name_ar')->nullable(false)->change();
            $table->text('name_fr')->nullable(false)->change();
        });
    }
};
