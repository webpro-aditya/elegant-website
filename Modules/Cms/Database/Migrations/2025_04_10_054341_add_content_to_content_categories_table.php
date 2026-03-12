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
            'name' => 'PRIVACY POLICY',
            'slug' => Str::slug('PRIVACY POLICY', '-'),
            'section' => 'web',
            'fields' => json_encode(['name', 'title', 'description', 'status'])
        ];
    
        $contentCategory = ContentCategory::updateOrCreate(
            ['slug' => $data['slug']], // Use slug for uniqueness
            $data
        );
    
        $englishLanguageId = Language::where('code', 'en')->value('id');
        $arabicLanguageId = Language::where('code', 'ar')->value('id');
    
    
        // Ensure category exists before proceeding
        $content = Content::create([
            'slug' => 'privacy-policy',
            'content_category_id' => $contentCategory->id,
            'page_slug' => 'privacy-policy',
            'fields' => json_encode(['name', 'title', 'description']),
            'is_deletable' => 1,
            'section' => 'web',
        ]);
    
        $translations = [
            [
                'name' => 'This page provides instructions about the legal Terms & Conditions.',
                'title' => 'Privacy Policy',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'توفر هذه الصفحة تعليمات حول الشروط والأحكام القانونية.',
                'title' => 'سياسة الخصوصية',
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

        // ----------------------

        $data = [
            'name' => 'TERMS AND CONDITIONS',
            'slug' => Str::slug('TERMS AND CONDITIONS', '-'),
            'section' => 'web',
            'fields' => json_encode(['name', 'title', 'description', 'status'])
        ];
    
        $contentCategory = ContentCategory::updateOrCreate(
            ['slug' => $data['slug']], // Use slug for uniqueness
            $data
        );
    
        $englishLanguageId = Language::where('code', 'en')->value('id');
        $arabicLanguageId = Language::where('code', 'ar')->value('id');
    
    
        // Ensure category exists before proceeding
        $content = Content::create([
            'slug' => Str::slug('TERMS AND CONDITIONS', '-'),
            'content_category_id' => $contentCategory->id,
            'page_slug' => Str::slug('TERMS AND CONDITIONS', '-'),
            'fields' => json_encode(['name', 'title', 'description']),
            'is_deletable' => 1,
            'section' => 'web',
        ]);
    
        $translations = [
            [
                'name' => 'Welcome to Elegant Training Centre. These Terms and Conditions govern your use of our website and services. By accessing or using our platform, you agree to comply with the following terms.',
                'title' => 'Terms and Conditions',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'أهلاً بكم في مركز إليجانت للتدريب. تُنظّم هذه الشروط والأحكام استخدامكم لموقعنا الإلكتروني وخدماتنا. بدخولكم إلى منصتنا أو استخدامها، فإنكم توافقون على الالتزام بالشروط التالية.',
                'title' => 'الشروط والأحكام',
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

        $contentCategory = ContentCategory::where('slug', Str::slug('TERMS AND CONDITIONS', '-'))->first();
    
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
