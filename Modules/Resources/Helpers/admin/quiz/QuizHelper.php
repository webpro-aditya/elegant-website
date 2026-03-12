<?php

namespace Modules\Resources\Helpers\admin\quiz;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Cms\Entities\Language;
use Modules\Resources\Entities\FreeResource;
use Modules\Resources\Entities\Quiz;
use Modules\Resources\Entities\ResourceLocal;
use Modules\Resources\Entities\QuizLocal;

class QuizHelper
{
    public function getDatatable($data)
    {
        $quizQuery = Quiz::select(app(Quiz::class)->getTable() . '.*')
            ->with('locales');

        if (isset($data['status'])) {
            $quizQuery->where('status', '=', $data['status']);
        }

        if (isset($data['resource_id'])) {
            $quizQuery->where('resource_id', $data['resource_id']);
        }

        $quizzes = $quizQuery->get();


        $resourcesWithQuestions = $quizzes->map(function ($resource) {
            $locale = $resource->locales->firstWhere('language_id', 1);
            $resource->name_for_language_1 = $locale ? $locale->question : 'Title not found';
            return $resource;
        });
        
        return $resourcesWithQuestions;

    }

    public function getQuizContents($id)
    {
        $contentLocales = QuizLocal::where('quiz_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }
    public function save(array $input)
    {
        if ($resource = Quiz::create($input)) {
            return $resource;
        }

        return false;
    }
    public function update($data)
    {
        $resource = Quiz::find($data['id']);
        if ($resource->update($data)) {
            return $resource;
        }

        return false;
    }
    public function get($id)
    {
        return Quiz::findOrFail($id);
    }

    public function delete($id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

}