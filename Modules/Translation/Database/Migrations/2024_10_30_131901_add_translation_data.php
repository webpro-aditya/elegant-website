<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Translation\Entities\Translation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $translations = [
            ['key' => 'quiz_analysis', 'value_en' => 'Quiz Analysis', 'value_ar' => 'تحليل الاختبار'],
            ['key' => 'rank', 'value_en' => 'Rank', 'value_ar' => 'رتبة'],
            ['key' => 'participants', 'value_en' => 'Participants', 'value_ar' => 'مشاركون'],
            ['key' => 'go_to_quiz', 'value_en' => 'Go To Quiz', 'value_ar' => 'اذهب إلى الاختبار'],
            ['key' => 'time', 'value_en' => 'Time', 'value_ar' => 'وقت'],
            ['key' => 'accuracy', 'value_en' => 'Accuracy', 'value_ar' => 'دقة'],
            ['key' => 'view_solution', 'value_en' => 'View Solution', 'value_ar' => 'عرض الحل'],
            ['key' => 'submit_quiz', 'value_en' => 'Submit Quiz', 'value_ar' => 'إرسال الاختبار'],
            ['key' => 'previous', 'value_en' => 'Previous', 'value_ar' => 'سابق'],
            ['key' => 'next', 'value_en' => 'Next', 'value_ar' => 'التالي'],
            ['key' => 'question', 'value_en' => 'Question', 'value_ar' => 'سؤال'],
        ];

        foreach ($translations as $translation) {
            Translation::create($translation);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Translation::truncate();
    }
};
