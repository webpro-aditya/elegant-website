<?php

namespace Modules\Career\Helpers\Web;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Career\Entities\Career;
use Modules\Career\Entities\CareerApplicant;
use Modules\Career\Entities\CareerCategory;
use Modules\Career\Entities\CareerLocale;
use Modules\Cms\Entities\Language;

class CareerHelper
{
    public function getAllCategories()
    {
        $locale = config('app.locale');

        $categories = CareerCategory::where('status', 'active')
            ->whereHas('careers') 
            ->with(['careers.locales', 'careers.defaultLocale'])
            ->get()
            ->map(function ($category) use ($locale) {
                $category->name = $category->{'name_' . $locale};
    
                return $category;
            });
        return $categories;
    }

    public function getAllCareers()
    {
        return Career::with('category')->where('status', 'active')->get();
    }

    public function saveApplicant($data)
    {
        if ($career = CareerApplicant::create($data)) {
            return $career;
        }

        return false;
    }

    public function getCareer($id)
    {
        return Career::with('locales', 'defaultLocale')->find($id);
    }
}