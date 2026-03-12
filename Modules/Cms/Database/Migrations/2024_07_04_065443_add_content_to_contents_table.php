<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentCategory;
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
            'slug' => Str::slug('about-us-1', '-'),
            'page_slug' => 'about-us',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Online Learning Website',
                'short_description' => 'Elegant Training is the',
                'title' => 'about-us-1',
                'description' => 'Lorem ipsum dolor sit amet consectetur. Tortor risus ullamcorper commodo scelerisque iaculis turpis mi. Pulvinar velit in neque convallis. At aliquam a consectetur justo sit.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Site Web d apprentissage en ligne',
                'short_description' => 'La formation élégante est la',
                'title' => 'about-us-1',
                'description' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l imprimerie depuis les années ',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Sitio web de aprendizaje en línea',
                'short_description' => 'El entrenamiento elegante es el',
                'title' => 'about-us-1',
                'description' => 'Lorem ipsum dolor sit amet, ius deseruisse posidonium interesset id, soleat alterum menandri ut cum. Dicit propriae disputando qui ei. Amet fuisset assueverit ut eam, solet recusabo appellantur his ne. ',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'موقع التعلم عبر الإنترنت',
                'short_description' => 'التدريب الأنيق هو',
                'title' => 'about-us-1',
                'description' => 'إنشاء السيرة الذاتية التي تتمحور حول الملف االشخصيا لشخصي لشخصي',
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
            ];

            ContentLocale::create($translationData);
        }


        // ----------------------------------------------------------------------------------------


        $content = Content::create([
            'slug' => Str::slug('ecosystem', '-'),
            'page_slug' => 'about-us',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'An Ecosystem Where Everyone Can Excel',
                'title' => 'ecosystem',
                'content' => 'Breaking Language Barriers -> Language plays a major role in effective learning. And, not everyone finds it easy to learn in a language that is not their first. We break down these barriers by offering mentorship in a vernacular way.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Un écosystème où chacun peut exceller',
                'title' => 'ecosystem',
                'content' => 'Briser les barrières linguistiques -> La langue joue un rôle majeur dans un apprentissage efficace. Et tout le monde ne trouve pas facile d’apprendre dans une langue qui n’est pas sa première. Nous éliminons ces barrières en offrant du mentorat de manière vernaculaire',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Un ecosistema donde todos pueden sobresalir',
                'title' => 'ecosystem',
                'content' => 'Rompiendo las barreras del idioma -> El idioma juega un papel importante en el aprendizaje eficaz. Y no a todo el mundo le resulta fácil aprender en un idioma que no es el primero. Derribamos estas barreras ofreciendo tutoría de manera vernácula.',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'نظام بيئي حيث يمكن للجميع التفوق',
                'title' => 'ecosystem',
                'content' => 'كسر حواجز اللغة -> تلعب اللغة دورًا رئيسيًا في التعلم الفعال. ولا يجد الجميع أنه من السهل التعلم بلغة ليست الأولى لهم. نحن نكسر هذه الحواجز من خلال تقديم الإرشاد بطريقة عامية.',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'content' => $translation['content'],
            ];

            ContentLocale::create($translationData);
        }


        // ----------------------------------------------------------------------------------------

        $categories = [
            [
                'name' => 'CHANNEL VIDEOS',
                'slug' => Str::slug('CHANNEL VIDEOS', '-'),
                'section' => 'web',
                'fields' => json_encode(['title', 'name', 'link', 'status']) // Encode fields array to JSON string
            ],
            [
                'name' => 'MAJOR MILESTONES',
                'slug' => Str::slug('MAJOR MILESTONES', '-'),
                'section' => 'web',
                'fields' => json_encode(['title', 'name', 'content', 'status']) // Encode fields array to JSON string
            ]
        ];
        
        foreach ($categories as $category) {
            ContentCategory::updateOrCreate(
                ['name' => $category['name']], // Criteria for finding the record
                $category // Attributes to update or create
            );
        }
        // ----------------------------------------------------------------------------------------


        $content = Content::create([
            'slug' => Str::slug('life at image', '-'),
            'page_slug' => 'about-us',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Life at WsCube Tech',
                'title' => 'life-at-image',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'La vie chez WsCube Tech',
                'title' => 'life-at-image',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'La vida en WsCube Tech',
                'title' => 'life-at-image',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'الحياة في WsCube Tech',
                'title' => 'life-at-image',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
            ];

            ContentLocale::create($translationData);
        }


        // ----------------------------------------------------------------------------------------




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $slugs = [
            Str::slug('about-us-1', '-'),
            Str::slug('ecosystem', '-'),
            Str::slug('life at image', '-')
        ];

        foreach ($slugs as $slug) {
            $content = Content::where('slug', $slug)->where('section', 'web')->first();

            if ($content) {
                ContentLocale::where('content_id', $content->id)->delete();

                $content->delete();
            }
        }


        $categories = [
            'channel-videos',
            'major-milestones'
        ];
    
        // Delete the categories by their slugs
        ContentCategory::whereIn('slug', $categories)->delete();

    }
};
