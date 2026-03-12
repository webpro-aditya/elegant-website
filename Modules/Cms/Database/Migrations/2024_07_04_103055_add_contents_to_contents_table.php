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
            'slug' => Str::slug('join-us', '-'),
            'page_slug' => 'about-us',
            'is_deletable' => 1,
            'section' => 'web',
        ]);

        $translations = [
            [
                'name' => 'Join Us in Transforming Careers!',
                'description' => 'Lorem ipsum dolor sit amet consectetur. Tortor risus ullamcorper commodo scelerisque iaculis turpis mi.',
                'title' => 'join-us',
                'language_id' => $englishLanguageId
            ],
            [
                'name' => 'Site Web d apprentissage en ligne!',
                'description' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.',
                'title' => 'join-us',
                'language_id' => $frenchLanguageId
            ],
            [
                'name' => 'Únete a nosotros en la transformación de carreras!',
                'description' => 'Lorem ipsum dolor sit amet, expetendis elaboraret voluptatibus ut mei, cu eos prima nihil vocibus. Prima incorrupte nam ad, eos ei veri regione philosophia. Idque deseruisse his te. H',
                'title' => 'join-us',
                'language_id' => $spanishLanguageId
            ],
            [
                'name' => 'انضم إلينا في تحويل الوظائف!',
                'description' => 'تسبب يعادل الإنزال ضرب بل, ٣٠ قتيل، يرتبط اليابان، تحت. بل عدد جيوب بتخصيص. قد شيء علاقة ',
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
        $slug = Str::slug('join-us', '-');
        $content = Content::where('slug', $slug)->first();
    
        if ($content) {
            // Delete the translations associated with the content
            Content::where('id', $content->id)->delete();
    
            // Delete the content itself
            $content->delete();
        }
    }
    
};
