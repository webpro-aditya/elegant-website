<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentCategory;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;
use Modules\Cms\Entities\Page;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fields = ['name', 'title', 'short_desc', 'content', 'description', 'link','file', 'status', 'image-dropzone', 'thumbnail'];
        $jsonFields = json_encode($fields);

        $page = Page::create(['title' => 'CORPORATE TRAINING', 'fields' => $jsonFields, 'slug' => Str::slug('CORPORATE TRAINING', '-'), 'section' => 'web']);

        $englishLanguageId = Language::where('code', 'en')->pluck('id')->first();
        $frenchLanguageId = Language::where('code', 'fr')->pluck('id')->first();
        $spanishLanguageId = Language::where('code', 'sp')->pluck('id')->first();
        $arabicLanguageId = Language::where('code', 'ar')->pluck('id')->first();

        $content = Content::create([
            'slug' => Str::slug('corporate training', '-'),
            'page_slug' => $page->slug,
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Corporate Training',
                'title' => 'Corporate Training',
                'description' => 'Elegant Training Center is also offering flexible and Corporate Training in Dubai, tailor-made, high-in-demand on-site training sessions at any of the locations you choose. We always look for quality, not quantity that is why we have a qualified and experienced team and trainers who are ready to facilitate and cater to you.',
                'short_description' => 'Why choose Elegant Training Center as your training partner?',
                'content' => 'For a sustainable business culture, companies need to invest in employees through different corporate training programs and methodologies showing a company’s commitment to the employee’s betterment and enhancing their skills to achieve the company’s goal. Elegant Training Center provides 360-degree assistance to all your training requirements. Our L&D team creates standard outlines suitable for the current training market, in addition to this, we do a detailed TNA to understand the client requirement and formulate a tailor-made solution for maximum ROI. Normally it has been observed that untrained employees take up to six times longer to perform the same task as trained employees. Providing adequate Training for your employee can retain them in the company for a longer duration and obtain a great level of competency too. Elegant Training Center Team is committed to making all your training a good investment in your employees. Our corporate training is handled by Industry Veterans who engage the audience through instructional Training Practices.',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Formation en entreprise',
                'title' => 'Formation en entreprise',
                'description' => 'Elegant Training Center propose également des sessions de formation en entreprise flexibles et sur mesure à Dubai, adaptées aux demandes spécifiques et dispensées sur site, dans l un de vos locaux choisis. Nous privilégions toujours la qualité à la quantité, c est pourquoi notre équipe et nos formateurs qualifiés et expérimentés sont prêts à vous accompagner et à répondre à vos besoins.',
                'short_description' => 'Pourquoi choisir Elegant Training Center comme partenaire de formation ?',
                'content' => 'Pour une culture d entreprise durable, les entreprises doivent investir dans leurs employés à travers différents programmes et méthodologies de formation en entreprise, démontrant ainsi l engagement de l entreprise envers l amélioration de ses employés et le renforcement de leurs compétences pour atteindre les objectifs de l entreprise. Elegant Training Center offre une assistance à 360 degrés pour toutes vos exigences en matière de formation. Notre équipe de développement et de formation crée des programmes standard adaptés au marché actuel de la formation. De plus, nous réalisons une analyse détaillée des besoins pour comprendre les exigences spécifiques du client et formuler une solution sur mesure pour un retour sur investissement maximal. Il a été observé que les employés non formés prennent jusqu à six fois plus de temps pour effectuer la même tâche que les employés formés. Fournir une formation adéquate à vos employés peut les fidéliser plus longtemps dans l entreprise et leur permettre d atteindre un excellent niveau de compétence. L équipe d Elegant Training Center s engage à faire de toutes vos formations un bon investissement pour vos employés. Notre formation en entreprise est animée par des vétérans de l industrie qui captivent leur audience grâce à des pratiques pédagogiques instructives.',
                'language_id' => $frenchLanguageId,
            ],

            [
                'name' => 'Formación Corporativa',
                'title' => 'Formación Corporativa',
                'description' => 'Elegant Training Center también ofrece sesiones de formación corporativa flexibles y a medida en Dubai, adaptadas a las necesidades específicas y realizadas in situ en cualquiera de las ubicaciones que elija. Siempre buscamos calidad, no cantidad, por eso contamos con un equipo y formadores cualificados y experimentados que están listos para facilitar y atenderle.',
                'short_description' => '¿Por qué elegir Elegant Training Center como su socio de formación?',
                'content' => 'Para una cultura empresarial sostenible, las empresas deben invertir en sus empleados a través de diferentes programas y metodologías de formación corporativa, demostrando así el compromiso de la empresa con la mejora de sus empleados y el fortalecimiento de sus habilidades para lograr los objetivos de la empresa. Elegant Training Center ofrece asistencia integral para todas sus necesidades de formación. Nuestro equipo de desarrollo y formación crea esquemas estándar adecuados para el mercado actual de formación. Además, realizamos un análisis detallado de necesidades para comprender los requisitos del cliente y formular una solución a medida para obtener el máximo retorno de la inversión. Normalmente se ha observado que los empleados no capacitados tardan hasta seis veces más en realizar la misma tarea que los empleados capacitados. Proporcionar una formación adecuada a sus empleados puede retenerlos en la empresa durante más tiempo y permitirles alcanzar un excelente nivel de competencia. El equipo de Elegant Training Center se compromete a hacer de todas sus formaciones una buena inversión para sus empleados. Nuestra formación corporativa está dirigida por veteranos de la industria que cautivan a la audiencia a través de prácticas de formación instructivas.',
                'language_id' => $spanishLanguageId,
            ],

            [
                'name' => 'التدريب الشركي',
                'title' => 'التدريب الشركي',
                'description' => 'يقدم مركز التدريب الأنيق أيضًا جلسات تدريب مرنة ومخصصة للشركات في دبي، مصممة وفقًا للطلبات الخاصة ويتم تقديمها في أي من الأماكن التي تختارها. نحن دائمًا نبحث عن الجودة، لا الكمية، ولذلك لدينا فريق ومدربون مؤهلون ومتمرسون جاهزون لتسهيل وخدمتك.',
                'short_description' => 'لماذا تختار مركز التدريب الأنيق كشريك لتدريبك؟',
                'content' => 'من أجل ثقافة مؤسسية مستدامة، تحتاج الشركات إلى استثمار في موظفيها من خلال برامج ومنهجيات تدريب شركي مختلفة، تظهر التزام الشركة بتحسين موظفيها وتعزيز مهاراتهم لتحقيق أهداف الشركة. يقدم مركز التدريب الأنيق دعمًا شاملاً لجميع احتياجاتك التدريبية. يقوم فريقنا في قسم التنمية والتدريب بإنشاء خطط معيارية مناسبة لسوق التدريب الحالي. بالإضافة إلى ذلك، نقوم بإجراء تحليل تفصيلي لاحتياجات العميل لفهم المتطلبات الخاصة وصياغة حل مخصص لتحقيق أقصى عائد على الاستثمار. عادةً ما يُلاحظ أن الموظفين غير المدربين يستغرقون ما يصل إلى ستة مرات أطول لأداء نفس المهمة التي يقوم بها الموظفون المدربون. توفير تدريب مناسب لموظفيك يمكن أن يحافظ عليهم في الشركة لفترة أطول ويسمح لهم بتحقيق مستوى عالٍ من الكفاءة. يلقي فريق مركز التدريب الأنيق التدريب الشركي بإشراف خبراء صناعة يجذبون الجمهور من خلال ممارسات تدريبية تعليمية.',
                'language_id' => $arabicLanguageId,
            ]
        ];
        foreach ($translations as $translation) {
            $translationData = [
                'content_id' => $content->id,
                'language_id' => $translation['language_id'],
                'name' => $translation['name'],
                'title' => $translation['title'],
                'description' => $translation['description'],
                'short_description' => $translation['short_description'],
                'content' => $translation['content'],
            ];

            ContentLocale::create($translationData);
        }

        $category = ['name' => 'CORPORATE TRAINING COURSE', 'slug' => Str::slug('CORPORATE TRAINING COURSE', '-'), 'section' => 'web', 'fields' => ['title', 'name', 'description', 'status']];
        ContentCategory::updateOrCreate(
            ['name' => $category['name']], // Criteria for finding the record
            array_merge($category, ['fields' => json_encode($category['fields'])]) // Attributes to update or create
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retrieve the created entities
        $page = Page::where('title', 'CORPORATE TRAINING')->first();
        $content = Content::where('page_slug', $page->slug)->first();
        $category = ContentCategory::where('name', 'CORPORATE TRAINING COURSE')->first();
    
        // Delete translations
        ContentLocale::where('content_id', $content->id)->delete();
    
        // Delete content
        $content->delete();
    
        // Delete page
        $page->delete();
    
        // Delete content category
        $category->delete();
    }
    
};
