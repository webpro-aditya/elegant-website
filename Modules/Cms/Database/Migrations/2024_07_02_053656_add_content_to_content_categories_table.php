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
            ['name' => 'BANNER FEATURES', 'slug' => Str::slug('BANNER FEATURES', '-'), 'section' => 'web', 'fields' => ['name','title', 'course_id', 'status']],
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
            'banner-features',
        ];
    
        ContentCategory::whereIn('slug', $categories)->delete();

    }
};
