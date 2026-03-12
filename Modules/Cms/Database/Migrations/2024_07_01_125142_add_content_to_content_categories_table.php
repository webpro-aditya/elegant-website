<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\ContentCategory;
use Modules\Cms\Entities\Page;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            ['name' => 'JOIN NOW FOR COURSE', 'slug' => Str::slug('JOIN NOW FOR COURSE', '-'), 'section' => 'web', 'fields' => ['name','title', 'short_desc', 'description','course_id', 'status']],
        ];

        foreach ($categories as $category) {
            ContentCategory::updateOrCreate(
                ['name' => $category['name']], // Criteria for finding the record
                array_merge($category, ['fields' => json_encode($category['fields'])]) // Attributes to update or create
            );
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $categories = [
            'join-now-for-course',
        ];
    
        ContentCategory::whereIn('slug', $categories)->delete();
    }
};
