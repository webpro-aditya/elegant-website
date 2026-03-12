<?php

namespace Modules\Translation\Helpers;

use Modules\Translation\Entities\Translation;

class TranslationHelper
{
    public function getAll()
    {
        $translations = Translation::get();

        return $translations;
    }

    public function getByKey($key)
    {
        return Translation::where('key', $key)->first();
    }

    public function update( $input)
    { 
        $translation = Translation::where('key', $input['key'])->first();
        
        if (!empty($translation)) {
            $translation->value_en = $input['value_en'];
            $translation->value_ar = $input['value_ar'];
            $translation->save();
            cache()->forget('translation');  
        }
    }

    public function getKeyValue()
    {
        return Translation::select('key', 'value_en', 'value_ar')->get()->mapWithKeys(function ($item) {
            return [
                $item['key'] => [
                    'value_en' => $item['value_en'],
                    'value_ar' => $item['value_ar']
                ]
            ];
        });
    }
    
}
