<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Language;
use Modules\Settings\Entities\Setting;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $languages = Language::whereIn('code', ['en', 'ar', 'sp', 'fr'])->pluck('id', 'code');

        $keysToCreate = [
            'company_address_line1_',
            'company_address_line2_',
            'company_city_',
            'company_name_',
            'company_description_',

        ];

        foreach ($keysToCreate as $key) {
            foreach (['en', 'ar', 'sp', 'fr'] as $lang) {
                $newKey = "{$key}{$lang}";
                $languageId = $languages[$lang] ?? null;

                $existingSetting = Setting::where('key', $newKey)
                    ->where('language_id', $languageId)
                    ->first();

                if (!$existingSetting) {
                    Setting::create([
                        'key' => $newKey,
                        'value' => '', 
                        'language_id' => $languageId,
                        'category' => 'store', 
                    ]);
                }
            }
        }
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keysToDelete = [
            'company_address_line1_',
            'company_address_line2_',
            'company_city_',
            'company_name_',
        ];

        foreach ($keysToDelete as $key) {
            foreach (['en', 'ar', 'sp', 'fr'] as $lang) {
                $setting = Setting::where('key', "{$key}{$lang}")->first();

                if ($setting) {
                    $setting->delete();
                }
            }
        }
    }
};
