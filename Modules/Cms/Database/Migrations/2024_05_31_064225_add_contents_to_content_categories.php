<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\ContentCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            ['name' => 'TESTIMONIALS', 'slug' => Str::slug('TESTIMONIALS', '-'), 'section' => 'web', 'fields' => ['name','title', 'content','short_desc', 'thumbnail', 'description', 'image-dropzone', 'status']],
            ['name' => 'FAQ', 'slug' => Str::slug('FAQ', '-'), 'section' => 'web', 'fields' => ['name', 'title', 'content', 'status', 'course_id']],
            ['name' => 'TOP COMPANIES HIRING', 'slug' => Str::slug('TOP COMPANIES HIRING', '-'), 'section' => 'web', 'fields' => ['name', 'title', 'image-dropzone', 'status', 'course_id']],
       
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
            'testimonials',
            'faq',
            'top-companies-hiring'
        ];
    
        // Delete the categories by their slugs
        ContentCategory::whereIn('slug', $categories)->delete();
    }
};
