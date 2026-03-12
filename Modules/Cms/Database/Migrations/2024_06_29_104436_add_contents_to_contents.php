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
            'slug' => Str::slug('learning in your fingertips 1', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Elegant Training : Online Learning in Your Fingertips',
                'short_description' => 'Lorem Ipsum dolor sit',
                'title' => 'learning in your fingertips 1',
                'description' => 'Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut. Tempus ridiculus id turpis amet ac sit enim nec viverra. Porttitor eu adipiscing amet semper orci. Aliquam in consectetur facilisis enim sit non amet donec lobortis. Dictum mauris sollicitudin quis pharetra vitae. Turpis et ac convallis justo. Nullam nisl etiam purus egestas interdum nunc. Elit enim odio gravida porta congue sed habitant scelerisque elit. Nunc id viverra amet sed a eu quis. Lectus accumsan.',
                'content' => 'Lorem ipsum dolor sit amet consectetur. Est etiam purus morbi pretium egestas eget. Tempor sit vehicula enim tellus morbi fusce ante aliquam. Amet sed euismod in nibh risus eget posuere diam.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Formation élégante : l apprentissage en ligne à portée de main',
                'short_description' => 'Lorem Ipsum dolor assis',
                'title' => 'apprendre du bout des doigts 1',
                'description' => 'French Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut. Tempus ridiculus id turpis amet ac sit enim nec viverra. Porttitor eu adipiscing amet semper orci. Aliquam in consectetur facilisis enim sit non amet donec lobortis. Dictum mauris sollicitudin quis pharetra vitae. Turpis et ac convallis justo. Nullam nisl etiam purus egestas interdum nunc. Elit enim odio gravida porta congue sed habitant scelerisque elit. Nunc id viverra amet sed a eu quis. Lectus accumsan.',
                'content' => 'French Lorem ipsum dolor sit amet consectetur. Est etiam purus morbi pretium egestas eget. Tempor sit vehicula enim tellus morbi fusce ante aliquam. Amet sed euismod in nibh risus eget posuere diam.',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Capacitación elegante: aprendizaje en línea al alcance de su mano',
                'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos',
                'title' => 'aprendiendo en tus manos 1',
                'description' => 'Descubra el futuro de la educación con Elegant Training, su principal plataforma de aprendizaje en línea diseñada para llevar el conocimiento al alcance de su mano. Ya sea que esté buscando avanzar en su carrera, aprender una nueva habilidad o explorar un pasatiempo, nuestros cursos integrales están diseñados para satisfacer sus necesidades.',
                'content' => 'Spanish Lorem ipsum dolor sit amet consectetur. Est etiam purus morbi pretium egestas eget. Tempor sit vehicula enim tellus morbi fusce ante aliquam. Amet sed euismod in nibh risus eget posuere diam.',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'تدريب أنيق: التعلم عبر الإنترنت في متناول يدك',
                'short_description' => 'لوريم إيبسوم دولور الجلوس',
                'title' => 'التعلم في متناول يدك 1',
                'description' => 'انه كانتا واستمر استرجاع و, كل مكن جمعت معارضة. بين عن يعبأ الدول قُدُماً, وتم من مهمّات سنغافورة الإتفاقية. مع فاتّبع المشتّتون وبالتحديد، وفي, علاقة تكاليف من أخر, عل تمهيد الأول بأضرار مدن. وبعض اتّجة في أسر, بـ الجو غرّة، وبريطانيا أخذ, لكل بـ نتيجة اوروبا الوزراء.
                ثم حاول وحلفاؤها المؤلّفة فعل, كرسي وفرنسا الأمريكي انه قد. بالحرب الشرقية هذا لم. بـ فعل تشكيل المجتمع عشوائية, كردة الباهضة والكوري حيث عن. بحق عل أمّا عملية والفلبين, قد لهذه إعادة احداث حين. القادة الثانية جعل تم, دون أمّا السيطرة في, إعلان بالتوقيع الشّعبين بها هو.
                معاملة الصفحات وانتهاءً بال أم. انتهت لليابان والروسية من على, ذلك قد يذكر والمانيا. ثم الشرقي بالرّغم ويكيبيديا، على, المسرح اللازمة ضرب مع. وجزر بأيدي إيو أن. و يتم الستار بقيادة, الا وأزيز البولندي ان.
                ا          ن حيث أجزاء الاندونيسية, ما مئات وصافرات ولكسمبورغ عدد, أي تلك اللا سياسة مقاومة. يقوم التجارية تعد أي, ثم ا وفرنسا استمرار بها. أن بحث الثالث وباستثناء, تكتيكاً الإيطالية شيء ما, بعض إذ حكومة للحكومة. مما أم خيار الخارجية التقليدي, أي رئيس مايو تلك, ٠٨٠٤ وحتّى انذار هو أسر. تنفّس انتباه به، ٣٠. كلّ وزارة فاتّبع كل.',
                'content' => 'ثم حاول وحلفاؤها المؤلّفة فعل, كرسي وفرنسا الأمريكي انه قد. بالحرب الشرقية هذا لم. بـ فعل تشكيل المجتمع عشوائية, كردة الباهضة والكوري حيث عن. بحق عل أمّا عملية والفلبين, قد لهذه إعادة احداث حين. القادة الثانية جعل تم, دون أمّا السيطرة في, إعلان بالتوقيع الشّعبين بها هو.',
                'language_id' => $arabicLanguageId
            ]
        ];

        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'short_description' => $translation['short_description'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
                'content' => $translation['content'],
            ];

            ContentLocale::create($translationData);
        }

        // ----------------------------------------------------------------------------------------

        $content = Content::create([
            'slug' => Str::slug('learning in your fingertips 2', '-'),
            'page_slug' => 'home',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Elegant Training : Online Learning in Your Fingertips',
                'short_description' => 'Lorem Ipsum dolor sit',
                'title' => 'learning in your fingertips 2',
                'description' => 'Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut. Tempus ridiculus id turpis amet ac sit enim nec viverra. Porttitor eu adipiscing amet semper orci. Aliquam in consectetur facilisis enim sit non amet donec lobortis. Dictum mauris sollicitudin quis pharetra vitae. Turpis et ac convallis justo. Nullam nisl etiam purus egestas interdum nunc. Elit enim odio gravida porta congue sed habitant scelerisque elit. Nunc id viverra amet sed a eu quis. Lectus accumsan.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Formation élégante : l apprentissage en ligne à portée de main',
                'short_description' => 'Lorem Ipsum dolor assis',
                'title' => 'apprendre du bout des doigts 2',
                'description' => 'French Lorem ipsum dolor sit amet consectetur. Ut nulla quam et fermentum. Leo ultricies enim nibh urna nunc ac. At sit quisque proin sit a duis quam lectus ut. Tempus ridiculus id turpis amet ac sit enim nec viverra. Porttitor eu adipiscing amet semper orci. Aliquam in consectetur facilisis enim sit non amet donec lobortis. Dictum mauris sollicitudin quis pharetra vitae. Turpis et ac convallis justo. Nullam nisl etiam purus egestas interdum nunc. Elit enim odio gravida porta congue sed habitant scelerisque elit. Nunc id viverra amet sed a eu quis. Lectus accumsan.',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Capacitación elegante: aprendizaje en línea al alcance de su mano',
                'short_description' => ' Aprendizaje en Línea al Alcance de tus Dedos',
                'title' => 'aprendiendo en tus manos 2',
                'description' => 'Descubra el futuro de la educación con Elegant Training, su principal plataforma de aprendizaje en línea diseñada para llevar el conocimiento al alcance de su mano. Ya sea que esté buscando avanzar en su carrera, aprender una nueva habilidad o explorar un pasatiempo, nuestros cursos integrales están diseñados para satisfacer sus necesidades.',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'تدريب أنيق: التعلم عبر الإنترنت في متناول يدك',
                'short_description' => 'لوريم إيبسوم دولور الجلوس',
                'title' => 'التعلم في متناول يدك 2',
                'description' => 'انه كانتا واستمر استرجاع و, كل مكن جمعت معارضة. بين عن يعبأ الدول قُدُماً, وتم من مهمّات سنغافورة الإتفاقية. مع فاتّبع المشتّتون وبالتحديد، وفي, علاقة تكاليف من أخر, عل تمهيد الأول بأضرار مدن. وبعض اتّجة في أسر, بـ الجو غرّة، وبريطانيا أخذ, لكل بـ نتيجة اوروبا الوزراء.
                ثم حاول وحلفاؤها المؤلّفة فعل, كرسي وفرنسا الأمريكي انه قد. بالحرب الشرقية هذا لم. بـ فعل تشكيل المجتمع عشوائية, كردة الباهضة والكوري حيث عن. بحق عل أمّا عملية والفلبين, قد لهذه إعادة احداث حين. القادة الثانية جعل تم, دون أمّا السيطرة في, إعلان بالتوقيع الشّعبين بها هو.
                معاملة الصفحات وانتهاءً بال أم. انتهت لليابان والروسية من على, ذلك قد يذكر والمانيا. ثم الشرقي بالرّغم ويكيبيديا، على, المسرح اللازمة ضرب مع. وجزر بأيدي إيو أن. و يتم الستار بقيادة, الا وأزيز البولندي ان.
                ا          ن حيث أجزاء الاندونيسية, ما مئات وصافرات ولكسمبورغ عدد, أي تلك اللا سياسة مقاومة. يقوم التجارية تعد أي, ثم ا وفرنسا استمرار بها. أن بحث الثالث وباستثناء, تكتيكاً الإيطالية شيء ما, بعض إذ حكومة للحكومة. مما أم خيار الخارجية التقليدي, أي رئيس مايو تلك, ٠٨٠٤ وحتّى انذار هو أسر. تنفّس انتباه به، ٣٠. كلّ وزارة فاتّبع كل.',
                'language_id' => $arabicLanguageId
            ]
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

        // ----------------------------------------------------------------------------------------

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete content and its translations for "learning in your fingertips 1"
        $content1 = Content::where('slug', Str::slug('learning in your fingertips 1', '-'))->first();
        if ($content1) {
            ContentLocale::where('content_id', $content1->id)->delete();
            $content1->delete();
        }
    
        // Delete content and its translations for "learning in your fingertips 2"
        $content2 = Content::where('slug', Str::slug('learning in your fingertips 2', '-'))->first();
        if ($content2) {
            ContentLocale::where('content_id', $content2->id)->delete();
            $content2->delete();
        }
    
    }
    
};
