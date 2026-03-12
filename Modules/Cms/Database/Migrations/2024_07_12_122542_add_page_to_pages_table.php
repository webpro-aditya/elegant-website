<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentCategory;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;
use Modules\Cms\Entities\Page;
use Illuminate\Support\Str;

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
       
        $page = Page::where('slug', 'contact-us')->first(); // Use first() instead of get()
  
        $content = Content::create([
            'slug' => Str::slug('contact us', '-'),
            'page_slug' => $page->slug, // Accessing $page->slug directly
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'How Can We Help You?',
                'description' => 'Lorem ipsum dolor sit amet consectetur. Tortor risus ullamcorper commodo scelerisque iaculis turpis mi.',
                'title' => 'contact-us',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Site Web d apprentissage en ligne!',
                'description' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.',
                'title' => 'contact-us',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Únete a nosotros en la transformación de carreras!',
                'description' => 'Lorem ipsum dolor sit amet, expetendis elaboraret voluptatibus ut mei, cu eos prima nihil vocibus. Prima incorrupte nam ad, eos ei veri regione philosophia. Idque deseruisse his te. H',
                'title' => 'contact-us',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'انضم إلينا في تحويل الوظائف!',
                'description' => 'تسبب يعادل الإنزال ضرب بل, ٣٠ قتيل، يرتبط اليابان، تحت. بل عدد جيوب بتخصيص. قد شيء علاقة ',
                'title' => 'contact-us',
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

        // ----------------------------------------------------------------------------------------

        $category = ['name' => 'CONTACT INFORMATION', 'slug' => Str::slug('CONTACT INFORMATION', '-'), 'section' => 'web', 'fields' => ['title', 'name', 'description','content', 'short_desc', 'link', 'thumbnail', 'status']];
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
        $content = Content::where('slug', Str::slug('contact us', '-'))->first();
        if ($content) {
            ContentLocale::where('content_id', $content->id)->delete();
            $content->delete();
        }
    
        ContentCategory::where('slug', Str::slug('CONTACT INFORMATION', '-'))->delete();
    }
};

