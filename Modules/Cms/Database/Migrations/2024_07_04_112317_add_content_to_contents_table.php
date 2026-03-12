<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;
use Modules\Cms\Entities\Page;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fields = ['name', 'title', 'description', 'status', 'thumbnail'];

        Page::create(['title' => 'HIRING','fields'=>json_encode($fields), 'slug' => Str::slug('HIRING', '-'), 'section' => 'web']);
    
        $englishLanguageId = Language::where('code', 'en')->pluck('id')->first();
        $frenchLanguageId = Language::where('code', 'fr')->pluck('id')->first();
        $spanishLanguageId = Language::where('code', 'sp')->pluck('id')->first();
        $arabicLanguageId = Language::where('code', 'ar')->pluck('id')->first();

        // ----------------------------------------------------------------------------------------

        $content = Content::create([
            'slug' => Str::slug('hiring', '-'),
            'page_slug' => 'hiring',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'We Are Growing Fast and Looking for Amazing Team Members!',
                'description' => 'Are you passionate about making a difference and eager to grow your career in a dynamic environment? Look no further! We are expanding rapidly and seeking enthusiastic individuals to join our team.',
                'title' => 'join-us',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Nous grandissons rapidement et recherchons des membres d’équipe formidables !',
                'description' => 'Êtes-vous passionné par l’idée de faire une différence et désireux de développer votre carrière dans un environnement dynamique ? Cherchez pas plus loin! Nous sommes en pleine expansion et recherchons des personnes enthousiastes pour rejoindre notre équipe.',
                'title' => 'join-us',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => '¡Estamos creciendo rápidamente y buscamos miembros increíbles para el equipo!',
                'description' => '¿Le apasiona marcar la diferencia y está ansioso por hacer crecer su carrera en un entorno dinámico? ¡No busque más! Nos estamos expandiendo rápidamente y buscamos personas entusiastas para unirse a nuestro equipo.',
                'title' => 'join-us',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'نحن ننمو بسرعة ونبحث عن أعضاء فريق رائعين!',
                'description' => 'هل أنت متحمس لإحداث فرق وتتوق إلى تنمية حياتك المهنية في بيئة ديناميكية؟ لا مزيد من البحث! نحن نتوسع بسرعة ونبحث عن أفراد متحمسين للانضمام إلى فريقنا.',
                'title' => 'join-us',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];

            ContentLocale::create($translationData);
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $pageSlug = Str::slug('HIRING', '-');
        $page = Page::where('slug', $pageSlug)->first();
    
        if ($page) {
            // Delete the page record
            $page->delete();
        }
    
        $contentSlug = Str::slug('hiring', '-');
        $content = Content::where('slug', $contentSlug)->first();
    
        if ($content) {
            // Delete the translations associated with the content
            ContentLocale::where('content_id', $content->id)->delete();
    
            // Delete the content itself
            $content->delete();
        }
    }
    
};
