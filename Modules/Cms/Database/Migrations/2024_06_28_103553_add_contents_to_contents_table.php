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

        // ------------------------------------------------------------------------

        // Create Elegant Banner content and translations
     

        $contentBanner = Content::create([
            'slug' => Str::slug('Elegant Banner', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $bannerTranslations = [
            [
                'name' => 'Elegant Banner',
                'title' => 'Elegant Banner',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Bannière élégante',
                'title' => 'Elegant Banner',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Bandera elegante',
                'title' => 'Elegant Banner',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'راية أنيقة',
                'title' => 'Elegant Banner',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($bannerTranslations as $translation) {
            $translationData = [
                'content_id' => $contentBanner->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
            ];

            ContentLocale::create($translationData);
        }

        // ------------------------------------------------------------------------


        $contentCareer = Content::create([
            'slug' => Str::slug('Build Your Career, Your Way', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $careerTranslations = [
            [
                'name' => 'Build Your Career, Your Way',
                'description' => 'Empower yourself with the skills and knowledge to shape your career path. At Elegant Training, we offer flexible and personalized online courses tailored to your unique goals.',
                'title' => 'Build Your Career, Your Way',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Construisez votre carrière, à votre façon',
                'description' => 'Donnez-vous les compétences et les connaissances nécessaires pour façonner votre cheminement de carrière. Chez Elegant Training, nous proposons des cours en ligne flexibles et.',
                'title' => 'Build Your Career, Your Way',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Construye tu carrera, a tu manera',
                'description' => 'Empoderate con las habilidades y conocimientos para dar forma a tu trayectoria profesional. En Elegant Training, ofrecemos cursos en línea flexibles y personalizados adaptados.',
                'title' => 'Build Your Career, Your Way',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'قم ببناء حياتك المهنية، على طريقتك',
                'description' => 'قم بتمكين نفسك بالمهارات والمعرفة لتشكيل مسار حياتك المهنية. في Elegant Training، نقدم دورات مرنة وشخصية عبر الإنترنت مصممة خصيصًا لأهدافك الفريدة',
                'title' => 'Build Your Career, Your Way',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($careerTranslations as $translation) {
            $translationData = [
                'content_id' => $contentCareer->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];

            ContentLocale::create($translationData);
        }

        // ------------------------------------------------------------------------

 

        $contentLiveCourses = Content::create([
            'slug' => Str::slug('Live Online Courses', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $liveCoursesTranslations = [
            [
                'name' => 'Live Online Courses',
                'description' => 'Join our live sessions to stay motivated, ask questions, and collaborate with peers. Elevate your learning experience with us today!',
                'title' => 'Live Online Courses',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Cours en ligne en direct',
                'description' => 'Rejoignez nos sessions en direct pour rester motivé, poser des questions et collaborer avec vos pairs. Améliorez votre expérience d apprentissage avec nous dès aujourd hui !',
                'title' => 'Live Online Courses',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Cursos en línea en vivo',
                'description' => 'Únase a nuestras sesiones en vivo para mantenerse motivado, hacer preguntas y colaborar con sus compañeros. ¡Mejora tu experiencia de aprendizaje con nosotros hoy!',
                'title' => 'Live Online Courses',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'الدورات المباشرة عبر الإنترنت',
                'description' => 'انضم إلى جلساتنا المباشرة لتبقى متحمسًا وطرح الأسئلة والتعاون مع زملائك. ارفع مستوى تجربتك التعليمية معنا اليوم!',
                'title' => 'Live Online Courses',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($liveCoursesTranslations as $translation) {
            $translationData = [
                'content_id' => $contentLiveCourses->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];

            ContentLocale::create($translationData);
        }

        // ------------------------------------------------------------------------


        $contentOfflineCourses = Content::create([
            'slug' => Str::slug('Offline Courses', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $offlineCoursesTranslations = [
            [
                'name' => 'Offline Courses',
                'description' => 'Experience hands-on learning with our Offline Courses. Engage directly with expert instructors, collaborate with peers, and immerse yourself in interactive, in-person training sessions.',
                'title' => 'Offline Courses',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Cours hors ligne',
                'description' => 'Faites l expérience d un apprentissage pratique avec nos cours hors ligne. Interagissez directement avec des instructeurs experts, collaborez avec vos pairs et plongez-vous ',
                'title' => 'Offline Courses',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Cursos sin conexión',
                'description' => 'Únase a nuestras sesiones en vivo para mantenerse motivado, hacer preguntas y colaborar con ',
                'title' => 'Offline Courses',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'دورات دون اتصال',
                'description' => 'استمتع بالتعلم العملي من خلال دوراتنا غير المتصلة بالإنترنت. تفاعل مباشرة مع المدربين الخبراء، وتعاون مع أقرانك، وانغمس في جلسات تدريبية تفاعلية وشخصية',
                'title' => 'Offline Courses',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($offlineCoursesTranslations as $translation) {
            $translationData = [
                'content_id' => $contentOfflineCourses->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];

            ContentLocale::create($translationData);
        }

        // ------------------------------------------------------------------------

        // Create Self Paced Courses content and translations
        $fields = ['title', 'name', 'short_description', 'link', 'thumbnail'];
        $fieldsJson = json_encode($fields);

        $contentSelfPacedCourses = Content::create([
            'slug' => Str::slug('Self Paced Courses', '-'),
            'page_slug' => 'home',
            'fields' => $fieldsJson,
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $selfPacedCoursesTranslations = [
            [
                'name' => 'Self Paced Courses',
                'description' => 'Experience hands-on learning with our Self Paced . Engage directly with expert instructors, collaborate with peers, and immerse yourself in interactive, in-person training sessions.',
                'title' => 'Self Paced Courses',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Cours hors ligne',
                'description' => 'Faites l expérience d un apprentissage pratique avec nos cours hors ligne. Interagissez directement avec des instructeurs experts, collaborez avec vos pairs et .',
                'title' => 'Self Paced Courses',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Cursos sin conexión',
                'description' => 'Únase a nuestras sesiones en vivo para mantenerse motivado, hacer preguntas y colaborar con ',
                'title' => 'Self Paced Courses',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'دورات دون اتصال',
                'description' => 'استمتع بالتعلم العملي من خلال دوراتنا غير المتصلة بالإنترنت. تفاعل مباشرة مع المدربين الخبراء، وتعاون مع أقرانك، وانغمس في جلسات تدريبية تفاعلية وشخصية',
                'title' => 'Self Paced Courses',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($selfPacedCoursesTranslations as $translation) {
            $translationData = [
                'content_id' => $contentSelfPacedCourses->id,
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
    

        // Retrieve the IDs of the content records to be deleted
        $contentSlugs = [
            Str::slug('Elegant Banner', '-'),
            Str::slug('Build Your Career, Your Way', '-'),
            Str::slug('Live Online Courses', '-'),
            Str::slug('Offline Courses', '-'),
            Str::slug('Self Paced Courses', '-')
        ];

        $contents = Content::whereIn('slug', $contentSlugs)->get();

        foreach ($contents as $content) {
            ContentLocale::where('content_id', $content->id)->delete();
            $content->delete();
        }
    }

};
