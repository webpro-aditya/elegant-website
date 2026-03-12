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
        $categories = [
            ['name' => 'COMPANIES AND STARTUPS', 'slug' => Str::slug('COMPANIES AND STARTUPS', '-'), 'section' => 'web', 'fields' => ['name','title', 'image-dropzone', 'status']],
            ['name' => 'PLACEMENT ASSISTANCE', 'slug' => Str::slug('PLACEMENT ASSISTANCE', '-'), 'section' => 'web', 'fields' => ['name', 'title', 'link', 'short_desc', 'status','link','image-dropzone']],
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
            'companies-and-startups',
            'placement-assistance'
        ];
    
        // Delete the categories by their slugs
        ContentCategory::whereIn('slug', $categories)->delete();
    }
};
