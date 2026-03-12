<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->string('start_time', 50)->change();
            $table->string('end_time', 50)->change();
        });

        DB::table('batches')->update([
            'start_time' => DB::raw("CONCAT(start_time, ' AM')"),
            'end_time' => DB::raw("CONCAT(end_time, ' AM')")
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->time('start_time')->change();
            $table->time('end_time')->change();
        });

        DB::table('batches')->update([
            'start_time' => DB::raw("REPLACE(start_time, ' AM', '')"),
            'end_time' => DB::raw("REPLACE(end_time, ' AM', '')")
        ]);
    }
};
