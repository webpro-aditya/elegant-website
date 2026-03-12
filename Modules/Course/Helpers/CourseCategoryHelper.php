<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Entities\CourseCategoryLocal;

class CourseCategoryHelper
{
    public function searchCategory($keyword)
    {

        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $categories = CourseCategory::whereHas('locales', function ($query) use ($keyword, $englishId) {
            $query->where('language_id', $englishId)
                ->where('title', 'like', "%{$keyword}%");
        })
            ->with([
                'locales' => function ($query) use ($englishId) {
                    $query->where('language_id', $englishId);
                }
            ])
            ->paginate(30, ['*'], 'page', request()->get('page'));

        // Append the English title to each category object in the pagination result
        $categories->getCollection()->transform(function ($category) use ($englishId) {
            $category->title = $category->locales->first()->title ?? null;
            return $category;
        });
        return $categories;

    }

    public function save(array $input)
    {
        if ($category = CourseCategory::create($input)) {
            return $category;
        }

        return false;
    }


    public function getLocaleContents($id)
    {
        $contentLocales = CourseCategoryLocal::where('category_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function getCategoryDatatable($data)
    {
        $categories = CourseCategory::select(app(CourseCategory::class)->getTable() . '.*')->with('locales')
            ->whereNull('parent_category_id');

        if (isset($data['status'])) {
            $categories->where('status', $data['status']);
        }
        if (isset($data['parent_id'])) {
            $categories->where('parent_category_id', $data['parent_id']);
        }
        return $categories->get();
    }

    public function getsubCategoryDatatable($data)
    {

        $categories = CourseCategory::select(app(CourseCategory::class)->getTable() . '.*')->with('parent', 'locales')
            ->whereNotNull('parent_category_id');
        if (isset($data['status'])) {
            $categories->where('status', $data['status']);
        }
        if (isset($data['parent_id'])) {
            $categories->where('parent_category_id', $data['parent_id']);
        }

        return $categories->get();
    }

    public function delete($categoryId)
    {
        try {
            $category = CourseCategory::findOrFail($categoryId);
            $category->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getCategory($id)
    {
        return CourseCategory::find($id);
    }

    public function getCategoryWithTitle($id)
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $category = CourseCategory::with([
            'locales' => function ($query) use ($englishId) {
                $query->where('language_id', $englishId);
            }
        ])->find($id);

        // Append the English title to the category object
        // $category->title = $category?->locales->first()->title ?? null;
        if ($category) {
            // Append the English title safely
            $category->title = $category->locales->first()?->title ?? null;
        }

        return $category;
    }

    public function update($data)
    {
        $category = CourseCategory::find($data['id']);

        if ($category->update($data)) {
            return $category;
        }

        return false;
    }

    public function getAllCourseCategory()
    {
        $categories = CourseCategory::get();

        return $categories;
    }

    public function getCategoryBySlug($slug)
    {
        return CourseCategory::where('slug', $slug)->first();
    }

    public function getParentCategory()
    {
        return CourseCategory::whereNull('parent_category_id')->get();
    }
}
