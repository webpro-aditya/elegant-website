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
        // ------------------------------------------------------------------------

        $companyId = ContentCategory::where('slug', 'companies-and-startups')->pluck('id')->first();
        $fields = ['name', 'title', 'image-dropzone'];
        $fieldsJson = json_encode($fields);
        $content = Content::create([
            'slug' => Str::slug('Companies And Startups', '-'),
            'content_category_id' => $companyId,
            'page_slug' => 'companies-and-startups',
            'fields' => $fieldsJson,
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            ['name' => 'Our Learners Work at Global Companies & Startups', 'title' => 'Companies And Startups', 'language_id' => $englishLanguageId],
            ['name' => 'Nos apprenants travaillent dans des entreprises et startups mondiales', 'title' => 'Entreprises et Startups', 'language_id' => $frenchLanguageId],
            ['name' => 'Nuestros estudiantes trabajan en empresas y startups globales', 'title' => 'Empresas y Startups', 'language_id' => $spanishLanguageId],
            ['name' => 'عمل متعلمونا في الشركات العالمية والشركات الناشئة', 'title' => 'الشركات والشركات الناشئة', 'language_id' => $arabicLanguageId],
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


        // ------------------------------------------------------------------------

        $fields = ['title', 'name', 'description', 'link', 'thumbnail', 'link', 'image-dropzone'];
        $fieldsJson = json_encode($fields);

        $content = Content::create([
            'slug' => Str::slug('Elegant Training 1', '-'),
            'page_slug' => 'home',
            'fields' => $fieldsJson,
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            ['name' => 'Elegant Training: ', 'short_description' => 'Online Learning in Your Fingertips', 'title' => 'Elegant Training 1', 'description' => 'Discover the future of education with Elegant Training, your premier online learning platform designed to bring knowledge right to your fingertips. Whether you are looking to advance your career, learn a new skill, or explore a hobby, our comprehensive courses are tailored to meet your needs.', 'language_id' => $englishLanguageId],
            ['name' => 'Formation Élégante : ', 'short_description' => 'Apprentissage en Ligne à Portée de Main', 'title' => 'Formation Élégante 1', 'description' => 'Découvrez l avenir de l éducation avec Elegant Training, votre première plateforme d`apprentissage en ligne conçue pour mettre les connaissances à portée de main. Que vous cherchiez à faire progresser votre carrière, à acquérir de nouvelles compétences ou à explorer un passe-temps, nos cours complets sont adaptés à vos besoins.', 'language_id' => $frenchLanguageId],
            ['name' => 'Entrenamiento Elegante: ', 'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos', 'title' => 'Entrenamiento Elegante 1', 'description' =>'Descubra el futuro de la educación con Elegant Training, su principal plataforma de aprendizaje en línea diseñada para llevar el conocimiento al alcance de su mano. Ya sea que esté buscando avanzar en su carrera, aprender una nueva habilidad o explorar un pasatiempo, nuestros cursos integrales están diseñados para satisfacer sus necesidades.', 'language_id' => $spanishLanguageId],
            ['name' => 'التدريب الأنيق:', 'short_description' => '  التعلم عبر الإنترنت بين يديك', 'title' => 'التدريب الأنيق 1',  'description' => 'اكتشف مستقبل التعليم مع Elegant Training، منصة التعلم الرائدة عبر الإنترنت والمصممة لجلب المعرفة إلى متناول يدك. سواء كنت تتطلع إلى تطوير حياتك المهنية، أو تعلم مهارة جديدة، أو استكشاف هواية، فإن دوراتنا الشاملة مصممة لتلبية احتياجاتك.', 'language_id' => $arabicLanguageId]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'short_description' => $translation['short_description'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];

            ContentLocale::create($translationData);
        }



        // ------------------------------------------------------------------------

        $fields = ['title', 'name', 'description', 'link', 'thumbnail', 'link', 'image-dropzone'];
        $fieldsJson = json_encode($fields);

        $content = Content::create([
            'slug' => Str::slug('Elegant Training 2', '-'),
            'page_slug' => 'home',
            'fields' => $fieldsJson,
            'is_deletable' => 1,
            'section' => 'web',
        ]);


        $translations = [
            ['name' => 'Elegant Training: Online Learning in Your Fingertips', 'title' => 'Elegant Training 2', 'language_id' => $englishLanguageId],
            ['name' => 'Formation Élégante : Apprentissage en Ligne à Portée de Main', 'title' => 'Formation Élégante 2', 'language_id' => $frenchLanguageId],
            ['name' => 'Entrenamiento Elegante: Aprendizaje en Línea al Alcance de tus Dedos', 'title' => 'Entrenamiento Elegante', 'language_id' => $spanishLanguageId],
            ['name' => 'التدريب الأنيق: التعلم عبر الإنترنت بين يديك', 'title' => 'التدريب الأنيق 2', 'language_id' => $arabicLanguageId]
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

        // ------------------------------------------------------------------------

        $fields = ['title', 'name', 'description', 'content', 'thumbnail'];
        $fieldsJson = json_encode($fields);

        $content = Content::create([
            'slug' => Str::slug('Founder Homepage', '-'),
            'page_slug' => 'home',
            'fields' => $fieldsJson,
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            ['name' => 'Elegant Training: Online Learning in Your Fingertips', 'title' => 'Founder Homepage', 'language_id' => $englishLanguageId],
            ['name' => 'Formation Élégante : Apprentissage en Ligne à Portée de Main', 'title' => 'Page d`Accueil du Fondateur', 'language_id' => $frenchLanguageId],
            ['name' => 'Entrenamiento Elegante: Aprendizaje en Línea al Alcance de tus Dedos', 'title' => 'Página de Inicio del Fundador', 'language_id' => $spanishLanguageId],
            ['name' => 'التدريب الأنيق: التعلم عبر الإنترنت بين يديك', 'title' => 'الصفحة الرئيسية للمؤسس', 'language_id' => $arabicLanguageId],
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

        // ------------------------------------------------------------------------

        $fields = ['title', 'name', 'short_desc', 'link', 'image-dropzone'];
        $fieldsJson = json_encode($fields);

        $content = Content::create([
            'slug' => Str::slug('Placement Assistance', '-'),
            'page_slug' => 'home',
            'fields' => $fieldsJson,
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            ['name' => 'Placement Assistance to Get Hired Faster', 'title' => 'Placement Assistance', 'language_id' => $englishLanguageId],
            ['name' => 'Assistance au Placement pour Être Recruté Plus Rapidement', 'title' => 'Assistance au Placement', 'language_id' => $frenchLanguageId],
            ['name' => 'Asistencia para Colocación para Ser Contratado Más Rápido', 'title' => 'Asistencia para Colocación', 'language_id' => $spanishLanguageId],
            ['name' => 'المساعدة في التوظيف للحصول على عمل بشكل أسرع', 'title' => 'المساعدة في التوظيف', 'language_id' => $arabicLanguageId],
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
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        // Delete all the records created in the up function
        Content::where('slug', Str::slug('Companies And Startups', '-'))->delete();
        Content::where('slug', Str::slug('Elegant Training 1', '-'))->delete();
        Content::where('slug', Str::slug('Elegant Training 2', '-'))->delete();
        Content::where('slug', Str::slug('Founder Homepage', '-'))->delete();
        Content::where('slug', Str::slug('Placement Assistance', '-'))->delete();

        Schema::enableForeignKeyConstraints();
    }
};
