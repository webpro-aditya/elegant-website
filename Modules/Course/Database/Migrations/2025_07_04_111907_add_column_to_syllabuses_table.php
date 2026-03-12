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
        // Step 1: Add the column
        Schema::table('syllabuses', function (Blueprint $table) {
            $table->integer('sort_order')->nullable()->after('id');
        });

        // Step 2: Update sort_order based on course_id
        $syllabuses = DB::table('syllabuses')
            ->select('id', 'course_id')
            ->orderBy('course_id')
            ->orderBy('id') // Optional: sort by id to keep insertion order
            ->get();

        $courseSortIndexes = [];

        foreach ($syllabuses as $syllabus) {
            $courseId = $syllabus->course_id;
            $sortOrder = $courseSortIndexes[$courseId] ?? 1;

            DB::table('syllabuses')
                ->where('id', $syllabus->id)
                ->update(['sort_order' => $sortOrder]);

            $courseSortIndexes[$courseId] = $sortOrder + 1;
        }
    }

    public function down(): void
    {
        Schema::table('syllabuses', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
