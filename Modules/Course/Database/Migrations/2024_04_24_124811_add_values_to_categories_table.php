<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Course\Entities\CourseCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            ['name' => 'Instructor Led Learning', 'slug' => 'instructor-led-learning', 'status' => 'active', 'section' => 'lms'],
            ['name' => 'E-Learning', 'slug' => 'e-learning', 'status' => 'active', 'section' => 'lms'],
            ['name' => 'Technical Programs', 'slug' => 'technical-programs', 'status' => 'active', 'section' => 'web'],
            ['name' => 'HSE Technical Programs', 'slug' => 'hse-technical-programs', 'status' => 'active', 'section' => 'web'],
            ['name' => 'Non Technical Programs', 'slug' => 'non-technical-programs', 'status' => 'active', 'section' => 'web'],
            ['name' => 'Competence Assessor & Internal Verifier Programs', 'slug' => 'competence-assessor-internal-verifier-programs', 'status' => 'active', 'section' => 'web'],
            ['name' => 'Engineers Training & Placement Support Regards', 'slug' => 'engineers-training-placement-support-regards', 'status' => 'active', 'section' => 'web'],
        ];

        foreach ($categories as $categoryData) {
            CourseCategory::create($categoryData);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //  CourseCategory::truncate();
    }
};
