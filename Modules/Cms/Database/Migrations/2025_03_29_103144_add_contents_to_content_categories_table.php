<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentCategory;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $data = [
            'name' => 'OUR CLIENTS',
            'slug' => Str::slug('OUR CLIENTS', '-'),
            'section' => 'web',
            'fields' => json_encode(['name', 'title', 'image-dropzone', 'status'])
        ];
    
        $contentCategory = ContentCategory::updateOrCreate(
            ['slug' => $data['slug']], // Use slug for uniqueness
            $data
        );
    
        $englishLanguageId = Language::where('code', 'en')->value('id');
        $arabicLanguageId = Language::where('code', 'ar')->value('id');
    
    
        // Ensure category exists before proceeding
        $content = Content::create([
            'slug' => 'our-clients',
            'content_category_id' => $contentCategory->id,
            'page_slug' => 'our-clients',
            'fields' => json_encode(['name', 'title', 'image-dropzone']),
            'is_deletable' => 1,
            'section' => 'web',
        ]);
    
        $translations = [
            [
                'name' => 'We proudly serve diverse industries, building lasting relationships through quality solutions and exceptional service.',
                'title' => 'Our Clients',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'نحن نفخر بخدمة الصناعات المتنوعة، وبناء علاقات دائمة من خلال حلول عالية الجودة وخدمة استثنائية.',
                'title' => 'عملائنا',
                'language_id' => $arabicLanguageId
            ],
        ];
    
        foreach ($translations as $translation) {
            ContentLocale::create([
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
            ]);
        }
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $contentCategory = ContentCategory::where('slug', 'our-clients')->first();
    
        if ($contentCategory) {
            $contents = Content::where('content_category_id', $contentCategory->id)->get();
    
            foreach ($contents as $content) {
                ContentLocale::where('content_id', $content->id)->delete();
                $content->delete();
            }
    
            $contentCategory->delete();
        }
    }
    
};
