<?php

namespace Modules\Career\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Career\Entities\Career;
use Modules\Career\Entities\CareerLocale;
use Modules\Cms\Entities\Language;

class CareerHelper
{
    public function save(array $input)
    {
        if ($career = Career::create($input)) {
            return $career;
        }

        return false;
    }


    public function getDatatable($data)
    {
        $blogsQuery = Career::select(app(Career::class)->getTable() . '.*')->with('category', 'locales');

        if (isset($data['status'])) {
            $blogsQuery->where('status', '=', $data['status']);
        }

        if (isset($data['category_id'])) {
            $blogsQuery->where('category_id', '=', $data['category_id']);
        }

        return $blogsQuery;
    }


    public function get($id)
    {
        return Career::find($id);
    }

    public function getLocaleContents($id)
    {
        $contentLocales = CareerLocale::where('career_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function update($data)
    {
        $career = Career::find($data['id']);
        if ($career->update($data)) {
            return $career;
        }

        return false;
    }

    public function delete($id)
    {
        try {
            $career = Career::findOrFail($id);
            $career->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
    public function searchActiveCareer($keyword)
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();
    
        $careers = Career::whereHas('locales', function ($query) use ($keyword, $englishId) {
                $query->where('language_id', $englishId)
                      ->where('name', 'like', "%{$keyword}%");
            })
            ->byStatus(['active']) 
            ->select('careers.id', 'career_locales.name')
            ->join('career_locales', function ($join) use ($keyword, $englishId) {
                $join->on('careers.id', '=', 'career_locales.career_id')
                    ->where('career_locales.language_id', $englishId)
                    ->where('career_locales.name', 'like', "%{$keyword}%");
            })
            ->paginate(30, ['*'], 'page', request()->get('page'))->all();
    
            return $careers;
    }
}