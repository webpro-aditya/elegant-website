<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;

return new class extends Migration
{
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
            'slug' => Str::slug('home page founder card', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Elegant Training : Online Learning in Your Fingertips',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut.',
                'title' => 'home page founder card',
                'content' => 'Nolan Siphron, Founder, Elegant Training',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Formation élégante : l apprentissage en ligne à portée de main',
                'short_description' => 'Lorem Ipsum dolor assis',
                'title' => 'carte de fondateur de la page d accueil',
                'content' => 'Nolan Siphron, fondateur, Elegant Training',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Capacitación elegante: aprendizaje en línea al alcance de su mano',
                'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos',
                'title' => 'tarjeta de fundador de la página de inicio',
                'content' => 'Nolan Siphron, Fundador, Elegante Entrenamiento',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'تدريب أنيق: التعلم عبر الإنترنت في متناول يدك',
                'short_description' => 'لوريم إيبسوم دولور الجلوس',
                'title' => 'التعلم في متناول يدك 1',
                'content' => 'نولان سيفرون، مؤسس شركة Elegant Training',
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
        // Find the content by its slug
        $content = Content::where('slug', Str::slug('home page founder card', '-'))->first();
        
        if ($content) {
            // Delete the translations associated with the content
            ContentLocale::where('content_id', $content->id)->delete();
            
            // Delete the content itself
            $content->delete();
        }
    }
    
};
