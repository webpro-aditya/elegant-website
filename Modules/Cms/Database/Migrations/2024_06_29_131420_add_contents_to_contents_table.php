<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $englishLanguageId = Language::where('code', 'en')->pluck('id')->first();
        $frenchLanguageId = Language::where('code', 'fr')->pluck('id')->first();
        $spanishLanguageId = Language::where('code', 'sp')->pluck('id')->first();
        $arabicLanguageId = Language::where('code', 'ar')->pluck('id')->first();

        // ----------------------------------------------------------------------------------------

        $content = Content::create([
            'slug' => Str::slug('get hired faster 1', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Placement Assistance to Get Hired Faster',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut.',
                'title' => 'get hired faster 1',
                'description' => 'Profile-Centric Resume Creation',
                'content' => 'Lorem ipsum dolor sit amet consectetur.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Aide au placement pour être embauché plus rapidement',
                'short_description' => 'Lorem Ipsum dolor assis',
                'title' => 'être embauché plus rapidement 1',
                'description' => 'Création de CV centrée sur le profil',
                'content' => 'Lorem ipsum dolor sit amet consectetur.',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Asistencia de colocación para ser contratado más rápido',
                'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos',
                'title' => 'ser contratado más rápido 1',
                'description' => 'Creación de currículum centrada en el perfil',
                'content' => 'Lorem ipsum dolor sit amet consectetur.',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'المساعدة في التوظيف للحصول على توظيف أسرع',
                'short_description' => 'لوريم إيبسوم دولور الجلوس',
                'title' => 'الحصول على توظيف أسرع 1',
                'description' => 'إنشاء السيرة الذاتية التي تتمحور حول الملف الشخصي',
                'content' => 'لوريم إيبسوم دولور الجلوس',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'short_description' => $translation['short_description'],
                'description' => $translation['description'],
                'content' => $translation['content'],
            ];

            ContentLocale::create($translationData);
        }



        // ----------------------------------------------------------------------------------------

        $content = Content::create([
            'slug' => Str::slug('get hired faster 2', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Internship Opportunities',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut.',
                'title' => 'get hired faster 2',
                'description' => 'Interview Preparation & Mentorship',
                'content' => 'Lorem ipsum dolor sit amet consectetur.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Aide au placement pour être embauché plus rapidement',
                'short_description' => 'Lorem Ipsum dolor assis',
                'title' => 'être embauché plus rapidement 2',
                'description' => 'Création de CV centrée sur le profil',
                'content' => 'Lorem ipsum dolor sit amet consectetur.',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Asistencia de colocación para ser contratado más rápido',
                'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos',
                'title' => 'ser contratado más rápido 2',
                'description' => 'Creación de currículum centrada en el perfil',
                'content' => 'Lorem ipsum dolor sit amet consectetur.',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'المساعدة في التوظيف للحصول على توظيف أسرع',
                'short_description' => 'لوريم إيبسوم دولور الجلوس',
                'title' => 'الحصول على توظيف أسرع 2',
                'description' => 'إنشاء السيرة الذاتية التي تتمحور حول الملف الشخصي',
                'content' => 'لوريم إيبسوم دولور الجلوس',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'short_description' => $translation['short_description'],
                'description' => $translation['description'],
                'content' => $translation['content'],
            ];

            ContentLocale::create($translationData);
        }


    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Define the slugs to be deleted
        $slugs = [
            Str::slug('get hired faster 1', '-'),
            Str::slug('get hired faster 2', '-')
        ];

        // Loop through each slug and delete the associated content and translations
        foreach ($slugs as $slug) {
            // Find the content by its slug
            $content = Content::where('slug', $slug)->first();

            if ($content) {
                // Delete the translations associated with the content
                ContentLocale::where('content_id', $content->id)->delete();

                // Delete the content itself
                $content->delete();
            }
        }
    }

};
