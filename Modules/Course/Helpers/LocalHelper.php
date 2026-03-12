<?php

namespace Modules\Course\Helpers;

use Modules\Author\Entities\AuthorLocal;
use Modules\Blog\Entities\BlogLocale;
use Modules\Career\Entities\CareerLocale;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CalenderLocal;
use Modules\Course\Entities\CourseCategoryLocal;
use Modules\Course\Entities\CourseLocale;
use Modules\Course\Entities\SyllabusLocal;
use Modules\Course\Entities\Title;
use Modules\Faq\Entities\FaqLocal;
use Modules\Resources\Entities\ResourceLocal;

class LocalHelper
{
    public function getLanguageIdFromCode($languageCode){
        return Language::where('code', $languageCode)->value('id');
    }

    public function saveCourseCategoryLocal($data)
    {
        if ($local = CourseCategoryLocal::create($data)) {
            return $local;
        }

        return false;
    }

    public function getCourseCategoryWithLanguage($categoryId, $languageId)
    {
        return CourseCategoryLocal::where('category_id', $categoryId)
            ->where('language_id', $languageId)
            ->first();
    }


    public function saveSyllabusLocal($data)
    {
        if ($local = SyllabusLocal::create($data)) {
            return $local;
        }

        return false;
    }


    public function getTitleWithLanguage($title, $languageId)
    {
        return Title::where('language_id', $languageId)
        ->where('title', $title)
        ->first();
    }

    public function saveTitle($data)
    {
        if ($local = Title::create($data)) {
            return $local;
        }

        return false;
    }

    public function updateOrCreateSyllabusLocal(array $conditions, array $data)
    {
        SyllabusLocal::updateOrCreate($conditions, $data);
    }

    public function updateOrCreateTitle(array $conditions, array $data)
    {
        Title::updateOrCreate($conditions, $data);
    }

    public function saveCalenderLocal($data){
        return CalenderLocal::create($data);
    }

    public function getCalenderLocalWithLanguage($calenderId, $languageId)
    {
        return CalenderLocal::where('calander_id', $calenderId)
        ->where('language_id', $languageId)
        ->first();
    }

    public function saveFaqLocal($data){
        return FaqLocal::create($data);
    }

    public function saveCareerLocale($data){
        return CareerLocale::create($data);
    }

    public function updateOrCreateBlogLocale(array $conditions, array $data)
    {
        BlogLocale::updateOrCreate($conditions, $data);
    }

    public function saveBlogLocale(array $conditions, array $data)
    {
        BlogLocale::updateOrCreate($conditions, $data);
    }

    public function saveAuthorLocal($data)
    {
        return AuthorLocal::create($data);
    }

    public function saveResourceLocal($data)
    {
        return ResourceLocal::create($data);
    }


    public function saveCourseLocale($data)
    {
        return CourseLocale::create($data);
    }
}
