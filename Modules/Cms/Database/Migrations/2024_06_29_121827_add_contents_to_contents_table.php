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
            'slug' => Str::slug('training in numbers', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Elegant Training in Numbers',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut.',
                'title' => 'training in numbers',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Formation élégante : l apprentissage en ligne à portée de main',
                'short_description' => 'Lorem Ipsum dolor assis',
                'title' => 'formation aux chiffres',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Capacitación elegante: aprendizaje en línea al alcance de su mano',
                'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos',
                'title' => 'entrenamiento en números',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'تدريب أنيق: التعلم عبر الإنترنت في متناول يدك',
                'short_description' => 'لوريم إيبسوم دولور الجلوس',
                'title' => 'التدريب على الأرقام',
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
            ];

            ContentLocale::create($translationData);
        }

        // ----------------------------------------------------------------------------------------

        $content = Content::create([
            'slug' => Str::slug('elegant number 1', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Learners on Youtube',
                'short_description' => '3 M+',
                'title' => 'elegant number 1',
                'description' => '10 +',
                'content' => 'Training Domains',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Les apprenants sur Youtube',
                'short_description' => '3 M+',
                'title' => 'numéro élégant 1',
                'description' => '10 +',
                'content' => 'Domaines de formation',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Estudiantes en Youtube',
                'short_description' => '3 M+',
                'title' => 'numero elegante 1',
                'description' => '10 +',
                'content' => 'Dominios de entrenamiento',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'المتعلمون على اليوتيوب',
                'short_description' => '3 M+',
                'title' => '1 رقم أنيق',
                'description' => '10 +',
                'content' => 'مجالات التدريب',
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
            'slug' => Str::slug('elegant number 2', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Aspirants Trained',
                'short_description' => '150+',
                'title' => 'elegant number 2',
                'description' => '4.5/5',
                'content' => 'Average Learner Satisfaction',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Aspirants formés',
                'short_description' => '150+',
                'title' => 'numéro élégant 2',
                'description' => '4.5/5',
                'content' => 'Satisfaction moyenne des apprenants',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Aspirantes entrenados',
                'short_description' => '150+',
                'title' => 'numero elegante 2',
                'description' => '4.5/5',
                'content' => 'Satisfacción promedio del alumno',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'الطامحين المدربين',
                'short_description' => '150+',
                'title' => '2 رقم أنيق',
                'description' => '4.5/5',
                'content' => 'متوسط ​​رضا المتعلم',
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
            Str::slug('training in numbers', '-'),
            Str::slug('elegant number 1', '-'),
            Str::slug('elegant number 2', '-')
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
