<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\ContentCategory;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $category = ['name' => 'FEATURE', 'slug' => Str::slug('FEATURE', '-'), 'section' => 'web', 'fields' => ['title', 'name', 'description','thumbnail', 'course_id', 'status']];
        ContentCategory::updateOrCreate(
            ['name' => $category['name']], // Criteria for finding the record
            array_merge($category, ['fields' => json_encode($category['fields'])]) // Attributes to update or create
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ContentCategory::where('slug', 'feature')->delete();
    }
};
