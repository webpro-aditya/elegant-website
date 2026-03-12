<?php

namespace Modules\Faq\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Faq\Entities\FaqLocal;
use Modules\Faq\Entities\Faq;
use Modules\Cms\Entities\Language;

class FaqHelper
{
    public function save(array $input)
    {
        if ($faq = Faq::create($input)) {
            return $faq;
        }

        return false;
    }

    public function getDatatable($data)
    {
        $query = Faq::select(app(Faq::class)->getTable() . '.*')->with('locales');
      
        if (isset($data['status'])) {
            $query->where('status', '=', $data['status']);
        }

        if (isset($data['course_id'])) {
            $query->where('course_id', $data['course_id']);
        }
     
        $faq = $query->get();

      
        return $faq;
    
    }

    public function get($id)
    {
        return Faq::find($id);
    }
    public function update($data)
    {
        $faq = Faq::find($data['id']);
        if ($faq->update($data)) {
            return $faq;
        }

        return false;
    }

    public function getLocaleContents($id)
    {
        $contentLocales = FaqLocal::where('faq_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function delete($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getFaqByCourseId($courseId)
    {
        $faq = Faq::where('course_id', $courseId)->first();
        if($faq){
            return $faq;
        }else{
            return null;
        }
    }

    public function getFaqsByCourseId($courseId)
    {
        $faqs = Faq::where('course_id', $courseId)
                   ->with('locales', 'defaultLocale')
                   ->where('status', 'active') 
                   ->get();
    
        return $faqs;
    }
}